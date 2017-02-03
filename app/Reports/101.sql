SELECT 
	`CustomerNo`, 
	`CustomerName`, 
	COUNT(*) AS `ApplicationCount`, 
	SUM(IFNULL(`ApplicationBlocked`, 0)) AS `ApplicationBlockedCount`, 
	SUM(IFNULL(`ContentCount`, 0)) AS `ContentCount`, 
	SUM(IFNULL(`ContentApproval`, 0)) AS `ContentApprovalCount`, 
	SUM(IFNULL(`ContentBlocked`, 0)) AS `ContentBlockedCount`, 
	SUM(IFNULL(`AmountOfFileSize`, 0)) AS `AmountOfFileSize`, 
	SUM(IFNULL(`DownloadCount`, 0)) AS `DownloadCount`, 
	SUM(IFNULL(`AmountOfTraffic`, 0)) AS `AmountOfTraffic` 
FROM (
	SELECT 
		cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, 
		ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, ap.`ApplicationStatusID`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
		(SELECT COUNT(*) FROM `Content` WHERE `ApplicationID`=ap.`ApplicationID` AND `StatusID`=1) AS `ContentCount`, 
		(SELECT SUM(IFNULL(`Approval`, 0)) FROM `Content` WHERE `ApplicationID`=ap.`ApplicationID` AND `StatusID`=1) AS `ContentApproval`, 
		(SELECT SUM(IFNULL(`Blocked`, 0)) FROM `Content` WHERE `ApplicationID`=ap.`ApplicationID` AND `StatusID`=1) AS `ContentBlocked`, 
		(SELECT SUM(IFNULL(`TotalFileSize`, 0)) FROM `Content` WHERE `ApplicationID`=ap.`ApplicationID` AND `StatusID`=1) AS `AmountOfFileSize`,
		(SELECT COUNT(*) FROM `Log` WHERE `ApplicationID`=ap.`ApplicationID` AND `Url` LIKE '%?RequestTypeID=1001%' AND `Date` BETWEEN '{SD}' AND '{ED}') AS `DownloadCount`, 
		(SELECT SUM(`Size`) FROM `Log` WHERE `ApplicationID`=ap.`ApplicationID` AND `Date` BETWEEN '{SD}' AND '{ED}') AS `AmountOfTraffic`
		
	FROM `Customer` cu 
		INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
	WHERE 
		cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
		cu.`StatusID`=1
) t 
GROUP BY `CustomerNo`, `CustomerName`