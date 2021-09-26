<?php
require __DIR__ . '/../connection.php';



function set_query()
{
    $query =
        "SELECT
        history.user_id,
        personsqr_tbl.personname,
        personsqr_tbl.personmidname,
        personsqr_tbl.personfamname,
        personsqr_tbl.mobilenumber,

        CONCAT ( personsqr_tbl.personname, ', ' ,
                personsqr_tbl.personfamname, ' ', 
                personsqr_tbl.personmidname
        )
        as fullname,


        history.status,
        history.date_updated
    FROM 
        history 
    JOIN
        personsqr_tbl 
    ON
        history.user_id=personsqr_tbl.randomid";

    if (
        $_GET['search'] == null ||
        $_GET['search'] == ''
    ) {
        return $query;
    }

    $query = $query . " WHERE 

        CONCAT ( personsqr_tbl.personname, ', ' ,
                personsqr_tbl.personfamname, ' ', 
                personsqr_tbl.personmidname
        )
     LIKE  '%" . $_GET['search'] . "%' ";
    return $query;
}


$query = set_query();
$data = $conn->query(
    $query
);

?>


<form action="" method="get">
    <input type="text" name="search" class="form-control" placeholder="Search Person" value="<?php echo htmlspecialchars($_GET['search']); ?>">
    <input type="submit" class="btn btn-primary my-4 right">
</form>


<table class="table table-striped">
    <thead>
        </form>
        <tr>
            <th>Persons ID</th>
            <th>Status</th>
            <th>Fullname</th>
            <th>Number</th>
            <th>Date Updated</th>
        </tr>
    </thead>


    <tbody>

        <form action="updatetable.php" method="POST">

            <? echo mysqli_free_result($data); ?>
            <?php while ($row = mysqli_fetch_assoc($data)) : ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td>

                        <?php if ($row['status'] == 'positive') : ?>
                            <p class="bg-danger text-white text-center" style="text-transform: uppercase;">
                                <?php echo $row['status'] ?>
                            </p>
                        <?php elseif ($row['status'] == 'pui' ||  $row['status'] == 'pum') : ?>
                            <p class="bg-warning text-white text-center" style="text-transform: uppercase;">
                                <?php echo $row['status'] ?>
                            </p>
                        <?php elseif ($row['status'] == 'recovered') : ?>
                            <p class="bg-success text-white text-center" style="text-transform: uppercase;">
                                <?php echo $row['status'] ?>
                            </p>
                        <?php else : ?>
                            <p>
                                <?php echo $row['status'] ?>
                            </p>
                        <?php endif ?>
                    </td>
                    <td><?php echo $row['personfamname'] . ', ' .  $row['personname']  . ' ' . $row['personmidname'] ?></td>
                    <td><?php echo $row['mobilenumber']; ?></td>
                    <td><?php echo $row['date_updated']; ?></td>

                </tr>

            <?php endwhile; ?>
        </form>

    </tbody>
</table>


<script>
</script>