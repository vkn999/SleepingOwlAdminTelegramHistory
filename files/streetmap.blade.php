@if (isset($value['Latitude']) && isset($value['Longitude']))
  <div class="card card-outline card-success card-widget">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
     integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
     integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
     crossorigin=""></script>

    <div class="card-header">
      <h3 class="card-title form-group">
        Положение на карте
      </h3>
    </div>

    <div class="card-footer p-0">
      <div id="streetmap" style="height: 250px;"></div>
    </div>

    <script type="text/javascript">
    function ready() {
      var markermap = L.marker([
        {{ $value['Latitude'] }}, {{ $value['Longitude'] }}
      ]);

      var map = L.map('streetmap', {
        center: [{{ $value['Latitude'] }}, {{ $value['Longitude'] }}],
        zoom: 14,
        layers: [markermap]
      });


      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);


    }

    document.addEventListener("DOMContentLoaded", ready);
    </script>

  </div>
@endif
