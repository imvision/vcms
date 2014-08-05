<div class="row">
  <div class="col-md-12">
    <section class="panel">
        <div class="panel-body profile-information">
        <div class="col-md-3">
          <div class="profile-pic text-center">
            <img src="uploads/images/<?php echo $user['image'] ?>" alt=""/>
           </div>
        </div>
        <div class="col-md-6">
           <div class="profile-desk2">
               <h1><?php echo $user['first_name'] ?> <?php echo $user['last_name'] ?></h1>

               <table class="table  table-hover general-table">
                <tr>
                  <th>Email</th>
                  <td><?php echo $user['email']?></td>
                </tr>

                <tr>
                  <th>Gender</th>
                  <td><?php echo $user['gender']?></td>
                </tr>

                <tr>
                  <th>Age</th>
                  <td><?php echo $user['age']?></td>
                </tr>

                <tr>
                  <th>Country</th>
                  <td><?php echo $user['country']?></td>
                </tr>

               </table>

               <div class="row">
                  <div id="map" style="width:200px; height:200px">
                    <div id="map_canvas" style="width:100%; height:200px"></div>
                    <div id="crosshair"></div>
                  </div>
                </div>

                <br>

                <div class="row">
                  <a href="index.php?action=users" class="btn btn-primary">Back</a>
                  <a onclick="return confirm('Do you want to delete this user?');" href="index.php?action=user_delete&amp;id=<?php echo $user['user_id']?>&amp;ret=users" class="btn btn-danger">Delete</a>

                </div>
           </div>
        </div>
      </div>
    </section>
  </div>
</div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    var map;
    var geocoder;
    var centerChangedLast;
    var reverseGeocodedLast;
    var currentReverseGeocodeResponse;

    function initialize() {
        var latlng = new google.maps.LatLng( <?php echo $user['lat'] ?> , <?php echo $user['lng'] ?> );
        var myOptions = {
            zoom: 10,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        geocoder = new google.maps.Geocoder();

        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: "User's Location"
        });
    }

    initialize();
</script>
