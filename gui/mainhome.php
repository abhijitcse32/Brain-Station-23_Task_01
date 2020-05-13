<!DOCTYPE html>
<html>
<head>
	
</head>

<body class="hold-transition sidebar-mini layout-fixed">

	<center>
	<h1>Task: 01</h1>
	<table style="border: 1px solid #000">
	
		<thead>
			<tr>
			  <th style="border: 1px solid #000">Category Name</th>
			  <th style="border: 1px solid #000">Total Items</th>
			</tr>
		</thead>
		
		<tbody>
	
	<?php
	$sql="
	SELECT m.ParentcategoryId, n.Name, SUM(m.nof_item) nof_item
FROM(
SELECT ParentcategoryId, nof_item
FROM(
SELECT c.ParentcategoryId, count(b.id) nof_item
FROM item_category_relations a, item b, catetory_relations c
WHERE a.ItemNumber=b.Number
AND a.categoryId=c.categoryId
GROUP BY c.ParentcategoryId
    ) d
    WHERE ParentcategoryId NOT IN (select categoryId FROM catetory_relations)
    UNION
    SELECT e.ParentcategoryId, SUM(d.nof_item) nof_item
FROM(
SELECT c.ParentcategoryId, count(b.id) nof_item
FROM item_category_relations a, item b, catetory_relations c
WHERE a.ItemNumber=b.Number
AND a.categoryId=c.categoryId
GROUP BY c.ParentcategoryId
    ) d, catetory_relations e
    WHERE d.ParentcategoryId=e.categoryId
	AND e.ParentcategoryId NOT IN (select categoryId FROM catetory_relations)
    GROUP BY e.ParentcategoryId
	UNION
	SELECT g.ParentcategoryId, SUM(nof_item) nof_item
FROM(
SELECT e.ParentcategoryId, SUM(d.nof_item) nof_item
FROM(
SELECT c.ParentcategoryId, count(b.id) nof_item
FROM item_category_relations a, item b, catetory_relations c
WHERE a.ItemNumber=b.Number
AND a.categoryId=c.categoryId
GROUP BY c.ParentcategoryId
    ) d, catetory_relations e
    WHERE d.ParentcategoryId=e.categoryId
    GROUP BY e.ParentcategoryId
    ) f, catetory_relations g
    WHERE f.ParentcategoryId=g.categoryId
    GROUP BY g.ParentcategoryId
    ) m, category n
    WHERE m.ParentcategoryId=n.Id
    GROUP BY m.ParentcategoryId, n.Name
	";
	$oResult=$oBasic->SqlQuery($sql);
	for($i=0;$i<$oResult->num_rows;$i++)
	{
	?>
	
	<tr>
         <td style="border: 1px solid #000"><?php echo $oResult->rows[$i]['Name'];?></td>                  
         <td style="border: 1px solid #000"><?php echo $oResult->rows[$i]['nof_item'];?></td>                  
    </tr>
	
	<?php
	}
	?>
	
	</table>
	</center>
</body>
</html>
