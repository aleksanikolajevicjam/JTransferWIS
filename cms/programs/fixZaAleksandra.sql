UPDATE v4_OrderDetails AS d 
INNER JOIN v4_OrdersMaster AS m 
ON d.OrderID = m.MOrderID
SET d.UserID = m.MUserID, d.UserLevelID = m.MUserLevelID
WHERE d.UserID = '0'


UPDATE v4_OrderDetails AS d 
INNER JOIN v4_OrdersMaster AS m 
ON d.OrderID = m.MOrderID
SET d.OrderDate = m.MOrderDate
WHERE d.OrderDate = ''
