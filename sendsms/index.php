<?php
require __DIR__ . '/../connection.php';

$ids = $_POST['personids'];
$ids = array_unique($ids);




function set_query($persons)
{
  $query = " SELECT * FROM personsqr_tbl WHERE ";

  $arg = array();

  foreach ($persons as $person) {
    array_push($arg, "randomid = '" . $person . "'");
  }
  return $query  . implode(" OR ", $arg);
}

$query = set_query($ids);

$users = $conn->query($query);


?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Document</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

</head>

<body>


    <?php include __DIR__ . '/../includes/header.php' ?>
  <main class="container" x-data="dropdown">

    <div class="row">
      <div class="col">
        <h6>Set User Status </h6>
        <select name="status" class="form-select form-select-lg mb-3" x-model="status">
          <option key="none" value="">None</option>
          <option key="pui" value="pui">⚠️ PUI </option>
          <option key="pum" value="pum"> ⚠️ PUM</option>

        </select>
      </div>

      <div class="col">
        <h6> Message Template</h6>

        <select name="template" id="" class="form-select form-select-lg mb-3" x-model="template" x-on:change="onTemplateSelChange">
          <option key="pui_template" value="pui_template">PUI Message Template</option>
          <option key="pum_template" value="pum_template">PUM Message Template</option>
          <option key="custom" value="custom">Custom</option>
        </select>

      </div>
    </div>
    <div class="row" x-show="customMessageShow" x-transition>
      <div class="col">
        <h6>Message:</h6>
        <textarea name="" id="" cols="30" rows="10" x-model="message"></textarea>
      </div>
    </div>



    <hr>
    <h6>Send SMS to:</h6>
    <table class="table table-stripped" style="height:300; overflow: show;">
      <thead>
        <tr>
          <td>
            <b> Name</b>
          </td>
          <td>
            <b> Number</b>
          </td>
          <td></td>
        </tr>
      </thead>

      <tbody>
        <?php while ($row = $users->fetch_assoc()) : ?>

          <tr class="">
            <td>
              <?php echo $row['personName'] . " " .  $row['personMidName'] . " " . $row['personFamName'] ?>
            </td>
            <td>
              <?php echo $row['MobileNumber']  ?>
            </td>
            <td>
            </td>
          </tr>

        <?php endwhile; ?>
      </tbody>

    </table>
    <button @click="sendsms()" class="btn btn-primary" >Send SMS</button>
  </main>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('dropdown', () => ({
        template: '',
        message: '',

        status: '',
        customMessageShow: false,


        users: [
         <!-- <?php 
            $users = $conn->query($query);
            while ($row = $users->fetch_assoc()): ?> -->
          {
            id: <?php echo "'" . $row['RandomID'] . "'" ?>,
            number: <?php echo "'" . $row['MobileNumber'] . "'" ?>,

          },
          <?php endwhile; ?>
      ],

        isLoading: false,

        onTemplateSelChange() {
          this.customMessageShow = (this.template == "custom") ? true : false;

          if (this.template == "pui_template") {
            this.message = "You may have been in contact with a COVID positive. "
            return;
          }
          if (this.template == "pum_template") {
            this.message = "You may have been in contact with a COVID positive. "
            return;
          }
        },

        async sendsms() {
          let confirm = await Swal.fire({
            title: 'Send SMS to these people',
            text: 'You wont be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
          })

          if (!confirm.isConfirmed){ return }

          await Swal.fire({
            didOpen: async () =>{
              Swal.showLoading();

              await this.users.forEach(async(item, index) => {
                /*
                let sms = await axios.post ('http://139.180.129.36/sendsms', {
                  to: item.number,
                  message: this.message,
                })

                console.log('SMS Server' , sms)
                */

                let local = await axios.post('updateStatus.php', {
                  id: item.id,
                  status: this.status
                })
                
                console.log('local' , local.data)

              })
              Swal.hideLoading();
            }

          });

        }

      }))
    })
  </script>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script defer src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script defer src="https://unpkg.com/axios/dist/axios.min.js"></script>

</body>

</html>