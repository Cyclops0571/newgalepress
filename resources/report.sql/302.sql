SELECT COUNT(*) AS `DownloadCount`,
	(CASE 
		WHEN rq.`DeviceOS` = 1 THEN 'iOS' 
		WHEN rq.`DeviceOS` = 2 THEN 'Android' 
	END ) AS `Device` 
FROM `Customer` cu 
	INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
	INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
	INNER JOIN `Request` rq ON rq.`ContentID`=cn.`ContentID` 
WHERE 
	cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) 
	AND ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) 
	AND cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) 
	AND cu.`StatusID`=1 
	AND rq.`RequestTypeID`=1001 
	AND rq.`RequestDate` BETWEEN '{SD}' AND '{ED}' 
	AND rq.`DeviceOS`BETWEEN 1 AND 2
	AND rq.`Percentage`=100
GROUP BY rq.DeviceOS