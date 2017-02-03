SELECT 
	`CustomerID`,
	`CustomerNo`,
	`CustomerName`,
	sum(`DonwloadCount`),
	(
	SELECT 
		sum(`DonwloadCount`)
	FROM ReportLocation
	WHERE
		RequestDate BETWEEN '{SD}' AND '{ED}' 
		AND (`Country` = {COUNTRY} OR {COUNTRY} IS NULL) 
		AND (`City` = {CITY} OR {CITY} IS NULL) 
		AND (`District` = {DISTRICT} OR {DISTRICT} IS NULL)
		AND (`CustomerID` = {CUSTOMERID} OR {CUSTOMERID} IS NULL) 
		AND (`ApplicationID` = {APPLICATIONID} OR {APPLICATIONID} IS NULL) 
		AND (`ContentID` = {CONTENTID} OR {CONTENTID} IS NULL) 
	) as `TotalDonwloadCount`,
	(sum(`DonwloadCount`) * 100 / 
		(
		SELECT 
			sum(`DonwloadCount`)
		FROM ReportLocation
		WHERE
			RequestDate BETWEEN '{SD}' AND '{ED}' 
			AND (`Country` = {COUNTRY} OR {COUNTRY} IS NULL) 
			AND (`City` = {CITY} OR {CITY} IS NULL) 
			AND (`District` = {DISTRICT} OR {DISTRICT} IS NULL)
			AND (`CustomerID` = {CUSTOMERID} OR {CUSTOMERID} IS NULL) 
			AND (`ApplicationID` = {APPLICATIONID} OR {APPLICATIONID} IS NULL) 
			AND (`ContentID` = {CONTENTID} OR {CONTENTID} IS NULL) 
		)
	) AS Percent,
	`Type`,
	`RequestDate`,
	`ApplicationID`,
	`ApplicationName`,
	`ContentID`,
	`ContentName`,
	`Country`,
	`City`,
	`District`
FROM
	ReportLocation
WHERE
	RequestDate BETWEEN '{SD}' AND '{ED}' 
	AND (`Country` = {COUNTRY} OR {COUNTRY} IS NULL) 
	AND (`City` = {CITY} OR {CITY} IS NULL) 
	AND (`District` = {DISTRICT} OR {DISTRICT} IS NULL)
	AND (`CustomerID` = {CUSTOMERID} OR {CUSTOMERID} IS NULL) 
	AND (`ApplicationID` = {APPLICATIONID} OR {APPLICATIONID} IS NULL) 
	AND (`ContentID` = {CONTENTID} OR {CONTENTID} IS NULL) 
	
GROUP BY `CustomerID`, `CustomerNo`, `CustomerName`, `ApplicationID`, `ApplicationName`, `ContentID`, `Country`, `City`, `District`
ORDER BY Percent DESC

