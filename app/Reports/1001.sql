SELECT 
	cu.`CustomerNo`, 
	cu.`CustomerName`, 
	ap.`Name` AS `ApplicationName`,
	cn.`ContentID`, cn.`Name` AS `ContentName`, 
	COUNT(*) AS `DownloadCount`
FROM `Customer` cu 
	INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
	INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
	INNER JOIN `Request` rq ON rq.`ContentID`=cn.`ContentID` 
WHERE 
	cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
	ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
	cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
	cu.`StatusID`=1
	AND rq.`RequestTypeID`=1001 
	AND rq.`RequestDate` BETWEEN '{SD}' AND '{ED}' 
	AND rq.`Percentage`=100
	GROUP BY cn.`ContentID`
	ORDER BY cn.`ContentID` DESC