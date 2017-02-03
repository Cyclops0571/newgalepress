SELECT 
	`CustomerNo`, 
	`CustomerName`,
	`DateCreated`,
	`ApplicationName`,
	`ExpirationDate`, 
	`ApplicationStatusName`, 
	`ApplicationBlocked`, 
	COUNT(*) AS `ContentCount`, 
	SUM(IFNULL(`ContentApproval`, 0)) AS `ContentApprovalCount`, 
	SUM(IFNULL(`ContentBlocked`, 0)) AS `ContentBlockedCount`, 
	SUM(IFNULL(`AmountOfFileSize`, 0)) AS `AmountOfFileSize`, 
	SUM(IFNULL(`DownloadCount`, 0)) AS `DownloadCount`,
	SUM(IFNULL(`AmountOfTraffic`, 0)) AS `AmountOfTraffic` 
FROM (
	SELECT 
		cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, cu.`DateCreated`,
		ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, (SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=ap.`ApplicationStatusID` AND `LanguageID`=1) AS `ApplicationStatusName`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
		cn.`ContentID`, cn.`Name` AS `ContentName`, IFNULL(cn.`Approval`, 0) AS `ContentApproval`, IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, cn.`TotalFileSize` AS `AmountOfFileSize`,
		(SELECT COUNT(*) FROM `Log` WHERE `ContentID`=cn.`ContentID` AND `Url` LIKE '%?RequestTypeID=1001%' AND `Date` BETWEEN '{SD}' AND '{ED}') AS `DownloadCount`, 
		(SELECT SUM(`Size`) FROM `Log` WHERE `ContentID`=cn.`ContentID` AND `Date` BETWEEN '{SD}' AND '{ED}') AS `AmountOfTraffic`
		
	FROM `Customer` cu 
		INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
		INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
	WHERE 
		cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
		ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
		cu.`StatusID`=1
) t 
GROUP BY 
	`CustomerNo`, `CustomerName`, 
	`ApplicationName`, `ExpirationDate`, `ApplicationStatusName`, `ApplicationBlocked`