@extends('layouts.template')

@section('styles')

<style>
    html,
    body,
    #map {
        height: 100%;
        width: 100%;
        margin: 0;
    }

    #map {
        height: calc(100vh - 56px);
        width: 100%;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div id="map"></div>

@endsection

@section('script')
<script>
    //map
    var map = L.map('map').setView([-7.7695046638297995, 110.37782895530609], 13);

    // Basemap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);


    /* GeoJSON Point */
    var point = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
            var popupContent = "Name: " + feature.properties.name + "<br>" +
                "Description: " + feature.properties.description + "<br>" +
                "Foto: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                "' class='img-thumbnail' alt='...'>" + "<br>";

            layer.on({
                click: function(e) {
                    layer.bindPopup(popupContent).openPopup();
                },
                mouseover: function(e) {
                    layer.bindTooltip(feature.properties.kab_kota).openTooltip();
                },
            });
        },
    });

    $.getJSON("{{ route('api.points') }}", function(data) {
        point.addData(data);
        map.addLayer(point);
    });

    /* GeoJSON Polyline */

    var polyline = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
            var popupContent = "Nama: " + feature.properties.name + "<br>" +
                "Deskripsi: " + feature.properties.description + "<br>" +
                "Foto: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                "' class='img-thumbnail' alt='...'>" + "<br>";

            layer.on({
                click: function(e) {
                    polyline.bindPopup(popupContent);
                },
                mouseover: function(e) {
                    polyline.bindTooltip(feature.properties.name);
                },
            });
        },
    });
    $.getJSON("{{ route('api.polylines') }}", function(data) {
        polyline.addData(data);
        map.addLayer(polyline);
    });

    /* GeoJSON Polygon */

    var polygon = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
            var popupContent = "Nama: " + feature.properties.name + "<br>" +
                "Deskripsi: " + feature.properties.description + "<br>" +
                "Foto: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                "' class='img-thumbnail' alt='...'>" + "<br>";

            layer.on({
                click: function(e) {
                    polygon.bindPopup(popupContent);
                },
                mouseover: function(e) {
                    polygon.bindTooltip(feature.properties.name);
                },
            });
        },
    });
    $.getJSON("{{ route('api.polygons') }}", function(data) {
        polygon.addData(data);
        map.addLayer(polygon);
    });

    // Create a GeoJSON layer for polygon data
    var Sleman = L.geoJson(null, {
        style: function(feature) {
            // Adjust this function to define styles based on your polygon properties
            var value = feature.properties.KECAMATAN; // Change this to your actual property name
            return {
                fillColor: getColor(value),
                weight: 2,
                opacity: 0,
                color: "red",
                dashArray: "3",
                fillOpacity: 0,
            };
        },
        onEachFeature: function(feature, layer) {
            // Adjust the popup content based on your polygon properties
            var content =
                "Kecamatan: " +
                feature.properties.WADMKC +
                "<br>";

            layer.bindPopup(content);
        },
    });

    // Function to generate a random color //
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Load GeoJSON //
    fetch('storage/SHP/SHP_Sleman.geojson')
        .then(response => response.json())
        .then(data => {
            L.geoJSON(data, {
                style: function(feature) {
                    return {
                        opacity: 1,
                        color: "black",
                        weight: 0.5,
                        fillOpacity: 0.5,
                        fillColor: getRandomColor(),
                    };
                },
                onEachFeature: function(feature, layer) {
                    var content = "Kecamatan : " + feature.properties.KECAMATAN;
                    layer.on({
                        click: function(e) {
                            // Fungsi ketika objek diklik
                            layer.bindPopup(content).openPopup();
                        },
                        mouseover: function(e) {
                            // Tidak ada perubahan warna saat mouse over
                            layer.bindPopup("Kecamatan : " + feature.properties.KECAMATAN, {
                                sticky: false
                            }).openPopup();
                        },
                        mouseout: function(e) {
                            // Fungsi ketika mouse keluar dari objek
                            layer.resetStyle(e
                                .target); // Mengembalikan gaya garis ke gaya awal
                            map.closePopup(); // Menutup popup
                        },
                    });
                }

            }).addTo(map);
        })
        .catch(error => {
            console.error('Error loading the GeoJSON file:', error);
        });

    //layer control
    var overlayMaps = {
        "point": point,
        "polyline": polyline,
        "polygon": polygon
    };

    var layerControl = L.control.layers(null, overlayMaps).addTo(map);
</script>
@endsection