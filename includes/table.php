<?php
require __DIR__ . '/../connection.php';



function set_query()
{
    $query = "
        SELECT
        CONCAT(personsqr_tbl.personFamName,
        ', ',
        personsqr_tbl.personName,
        ' ' ,
        personsqr_tbl.personMidName
        ) as Fullname
        ,
        personsqr_tbl.email,
        personsqr_tbl.mobilenumber,
        person_entered.*

        FROM

        person_entered
        JOIN personsqr_tbl
        ON person_entered.personid = personsqr_tbl.RandomID 
        ";


    if (empty($_GET)) {
        return $query;
    }


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
        <form>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>
                    <div class="d-flex flex-column" x-data="{samedate: false ,setDate () 
                                                                                {
                                                                                    return (this.samedate) ? this.frm: null
                                                                                },
                                                                                frm: ''
                    }">
                        <label for="">
                            <p>Starting date:</p>
                            <input type="date" name="fromdate" x-model="frm" />
                        </label>

                        <label for="" x-show="!samedate" x-transition>
                            <p>To date:</p>
                            <input type="date" name="todate" x-model="setDate()" />
                            <script>
                            </script>
                        </label>

                        <label for="">
                            <label for="">Same date: </label>

                            <input type="checkbox" name="todate" x-on:click="samedate = !samedate" />
                        </label>

                    </div>


                </th>
                <th>
                    <div class="d-flex flex-column">

                        <label for="">
                            <p>Starting date:</p>
                            <input type="time" name="fromtime" value="" />
                        </label>

                        <label for="">
                            <p>To date:</p>
                            <input type="time" name="totime" value="" />
                        </label>

                    </div>
                </th>
                <th>
                    <input type="submit" name="" value="search" />
                </th>

            </tr>
        </form>
        <tr>
            <th></th>
            <th>Persons ID</th>
            <th>FULLNAME</th>
            <th>Number</th>
            <th>Establishment</th>
            <th>DATE</th>
            <th>TIME</th>
            <th></th>
        </tr>
    </thead>


    <tbody>

        <form action="sendsms/" method="POST">

            <? echo mysqli_free_result($data); ?>
            <?php while ($row = mysqli_fetch_assoc($data)) : ?>
                <tr>
                    <td>
                        <input type="checkbox" name="personids[]" value="<?php echo htmlspecialchars($row['PersonID']) ?>" class="form-check-input" x-show="report" />
                    </td>
                    <td>
                        <b>
                            <?php echo $row['PersonID'] ?>
                        </b>
                    </td>

                    <td>
                        <b>
                            <?php echo $row['Fullname'] ?>
                        </b>
                    </td>
                    <td>
                        <?php echo $row['mobilenumber'] ?>
                    </td>
                    <td>
                        <?php echo $row['Establishment'] ?>
                    </td>
                    <td>
                        <?php echo $row['DATEIN'] ?>
                    </td>
                    <td>
                        <?php echo $row['TIMEIN'] ?>
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