SELECT 
	cu.`CustomerID`,
	ap.`ApplicationID`,
	cn.`ContentID`,
	cu.`CustomerNo`,
	cu.`CustomerName`, 
	cu.`DateCreated`,
	ap.`Name` AS `ApplicationName`, 
	ap.`ExpirationDate`, 
	(SELECT `DisplayName` FROM `GroupCodeLanguage` WHERE `GroupCodeID`=ap.`ApplicationStatusID` AND `LanguageID`=1) AS `ApplicationStatusName`, 
	IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
	cn.`Name` AS `ContentName`, 
	IFNULL(cn.`Approval`, 0) AS `ContentApproval`, 
	IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, 
	IFNULL(cn.`TotalFileSize`, 0) AS `AmountOfFileSize`,
	count(r.ContentID) AS `DownloadCount`,
	SUM(r.`DataTransferred`) AS `AmountOfTraffic`
FROM `Customer` cu 
	INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
	INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
	LEFT JOIN `Request` r on r.ContentID = cn.ContentID and r.RequestTypeID = 1001 and r.DataTransferred != 0 AND r.DateCreated BETWEEN '{SD}' AND '{ED}'
WHERE 
	cu.`CustomerID`= COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
	ap.`ApplicationID`= COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
	cn.`ContentID`= COALESCE({CONTENTID}, cn.`ContentID`) AND 
	cu.`StatusID`=1
group by cn.ContentID
order by cn.ContentID DESC