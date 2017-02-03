SELECT `Device`, COUNT(*) AS `DownloadCount` 
FROM (
	SELECT 
		`DeviceType`,
		--`Param5`, 
		(
		CASE  
			WHEN INSTR(`DeviceType`, 'iPhone') > 0 THEN 'iOS' 
			WHEN INSTR(`DeviceType`, 'iPad') > 0 THEN 'iOS' 
			WHEN INSTR(`DeviceType`, 'iPod') > 0 THEN 'iOS' 
			WHEN INSTR(`DeviceType`, 'BlackBerry') > 0 THEN 'BlackBerry' 
			WHEN INSTR(`DeviceType`, 'Android') > 0 THEN 'Android' 
			WHEN INSTR(`DeviceType`, 'Windows') > 0 THEN 'Windows' 
			WHEN INSTR(`DeviceType`, 'Linux') > 0 THEN 'Linux' 
			ELSE 'Other' 
			--WHEN INSTR(`Param5`, 'ios') > 0 THEN 'iOS' 
			--WHEN INSTR(`Param5`, 'android') > 0 THEN 'Android'
			--ELSE 'iOS'
		END
		) AS `Device` 
	FROM ( 
		SELECT 
			cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, 
 			ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, ap.`ApplicationStatusID`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
 			cn.`ContentID`, cn.`Name` AS `ContentName`, IFNULL(cn.`Approval`, 0) AS `ContentApproval`, IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, 
			rq.`DeviceType`, rq.`Size`
			--st.`Param5`
		FROM `Customer` cu 
			INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
			INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1
			INNER JOIN `Request` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`RequestTypeID`=1001 AND rq.`RequestDate` BETWEEN '{SD}' AND '{ED}'
			--INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND rq.`Date` BETWEEN '{SD}' AND '{ED}'
			--INNER JOIN `Statistic` st ON st.`ContentID`=cn.`ContentID` AND st.`Type`='10' AND st.`Time` BETWEEN '{SD}' AND '{ED}'
		WHERE
			cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
			ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
			cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
			cu.`StatusID`=1
	) t
) y 
WHERE `Device` IN ('iOS', 'Android')
GROUP BY `Device`