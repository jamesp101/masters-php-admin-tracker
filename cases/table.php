<?php
require __DIR__ . '/../connection.php';



function set_query()
{
    $query = "
    SELECT * FROM 
    personsqr_tbl
    WHERE 
    status = 'positive' or
    status = 'pum' or
    status =  'pui' or
    status = 'recovered'
    ORDER BY dateUpdated desc;
    ";


    if (empty($_GET)) {
        return $query;
    }

    $query = "
    SELECT * FROM 
    personsqr_tbl
    WHERE 
    status = 'positive' or
    status = 'pum' or
    status =  'pui'
    ORDER BY dateUpdated;
    ";

    $where  = array ();


    

    //$where = array ();
    // if ($fromdate != ''){

    //     $todate = ($todate == '') ? ' curdate() ' : $todate;
    //     array_push( $where ," ( person_entered.datein BETWEEN " . $fromdate . " AND " .  $todate . " )");
    // }


    // if ($fromtime !=''){
    //     $totime = ($totime == '') ? ' curtime() ' :  $totime;
    //     array_push( $where ," ( person_entered.timein BETWEEN " . $fromtime . " AND " .  $totime  ." )");

    // }


    // if (sizeof($where) == 0) {
    //     return $query;
    // }
    // $query = $query . ' WHERE ' . implode(' AND ' , $where) ;


    $fromdate  = ($_GET['fromdate'] == '') ? 'curdate()' : $_GET['fromdate'];
    $fromtime  = ($_GET['fromtime'] == '') ? '00:00' : $_GET['fromtime'];

    $todate    = ($_GET['todate'] == '' || $_GET['todate'] == "on")     ? 'curdate()' : $_GET['todate'];
    $totime    = ($_GET['totime'] == '')    ? '23:59' : $_GET['totime'];

    $between =
        "WHERE CONCAT(person_entered.datein, ' ', person_entered.timein) "
        . " BETWEEN '" . $fromdate . " " . $fromtime . "'  AND " .
        "'" . $todate . " " . $totime . "'";

    $query = $query . $between;

    return $query;
}


$query = set_query();
$data = $conn->query(
    $query
);


?>



<table class="table table-striped">
    <thead>
        </form>
        <tr>
            <th></th>
            <th>Persons ID</th>
            <th>Fullname</th>
            <th>Number</th>
            <th>Date Updated</th>
            <th>Status</th>
        </tr>
    </thead>


    <tbody>

        <form action="updatetable.php" method="POST">

            <? echo mysqli_free_result($data); ?>
            <?php while ($row = mysqli_fetch_assoc($data)) : ?>
                <tr>
                    <td>
                        <input type="checkbox" name="personids[]" value="<?php echo htmlspecialchars($row['RandomID']) ?>" class="form-check-input" x-show="report" />
                    </td>
                    <td>
                            <?php echo $row['RandomID'] ?>
                    </td>

                    <td>
                            <?php echo $row['personFamName'] . ', ' . $row['personName']  . ' ' . $row['personMidName'] ?>
                    </td>
                    <td>
                        <?php echo $row['MobileNumber'] ?>
                    </td>
                    <td>
                        <?php echo $row['dateUpdated'] ?>
                    </td>
                    <td>
                        <?php if( $row['status'] == 'positive'): ?>
                          <p class="bg-danger text-white text-center" style="text-transform: uppercase;">
                                <?php echo $row['status'] ?>
                          </p> 
                        <?php elseif ($row['status'] == 'pui' ||  $row['status'] == 'pum'): ?>
                          <p class="bg-warning text-white text-center" style="text-transform: uppercase;">
                                <?php echo $row['status'] ?>
                          </p> 
                        <?php elseif ($row['status'] == 'recovered'): ?>
                          <p class="bg-success text-white text-center" style="text-transform: uppercase;">
                                <?php echo $row['status'] ?>
                          </p> 
                          <?php else: ?>
                          <p>
                                <?php echo $row['status'] ?>
                          </p> 
                        <?php endif ?>
                    </td>

                </tr>

            <?php endwhile; ?>
            <tr>
                <td>

                <button type="submit"> Sumbit </button>
                </td>
            </tr>
        </form>

    </tbody>
</table>


<script>
</script>