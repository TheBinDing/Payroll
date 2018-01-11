<?php
    $sql_search = "  SELECT
                    E.Em_Fullname AS Em_Fullname,
                    CAST(S.Site_Name AS Text) AS Site_Name,
                    CAST(G.Group_Name AS Text) AS Group_Name,
                    CAST(P.Pos_Name AS Text) AS Pos_Name,
                    IL.List_Num AS List_Num,
                    IL.List_Price AS List_Price,
                    I.Item_Name AS Item_Name,
                    I.Item_Status AS Item_Status,
                    IL.List_Status AS List_Status,
                    PD.Per_Week AS Week
                FROM
                    [HRP].[dbo].[Item_List] IL,
                    [HRP].[dbo].[Employees] E ,
                    [HRP].[dbo].[Sites] S,
                    [HRP].[dbo].[Group] G,
                    [HRP].[dbo].[Position] P,
                    [HRP].[dbo].[Items] I,
                    [HRP].[dbo].[Periods] PD
                WHERE
                    IL.Em_ID = E.Em_ID
                    AND E.Site_ID = S.Site_ID
                    AND E.Group_ID = G.Group_ID
                    AND E.Pos_ID = P.Pos_ID
                    AND IL.Item_ID = I.Item_ID
                    AND IL.Per_ID = PD.Per_ID ";

    if(!empty($_SESSION['SuperSite']) && $_SESSION['SuperSite'] != '1') {
          $sql_search .= " AND S.Site_ID = '".$_SESSION['SuperSite']."' ";
    }
    $sql_search .= " AND List_Status = '".'รอการคำนวณ'."' ";

    echo $sql_search.'<br>';
?>