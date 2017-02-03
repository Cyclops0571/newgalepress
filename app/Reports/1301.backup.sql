SELECT 
	`CustomerNo`, 
	`CustomerName`,
	`ApplicationName`,
	`ContentName`,
	`Country`,
	`City`, 
	`District`, 
	COUNT(*) AS `DownloadCount`
FROM (
	SELECT 
		cu.`CustomerNo`, cu.`CustomerName`,
		ap.`Name` AS `ApplicationName`,
		cn.`Name` AS `ContentName`,
		IFNULL(st.`Country`, '') AS `Country`, IFNULL(st.`City`, '') AS `City`, IFNULL(st.`District`, '') AS `District`
	FROM `Customer` cu 
		INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
		INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
		INNER JOIN `Statistic` st ON st.`CustomerID`=cu.`CustomerID` AND st.`ApplicationID`=ap.`ApplicationID` AND st.`ContentID`=cn.`ContentID` AND st.`Type`='10' AND st.`Time` BETWEEN '{SD}' AND '{ED}' AND (st.`Country`={COUNTRY} OR {COUNTRY} IS NULL) AND (st.`City`={CITY} OR {CITY} IS NULL) AND (st.`District`={DISTRICT} OR {DISTRICT} IS NULL)
	WHERE 
		cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
		ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
		cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
		cu.`StatusID`=1
) t 
GROUP BY `CustomerNo`, `CustomerName`, `ApplicationName`, `ContentName`, `Country`, `City`, `District`