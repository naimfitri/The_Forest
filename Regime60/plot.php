<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tree Map with MapTiler</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="../config.js"></script>
  <link rel="stylesheet" href="styles.css">

<style>
    #victimCounts {
        background: white;
        padding: 10px;
        border: 2px solid #ccc;
        border-radius: 5px;
        position: absolute;
        bottom: 350px; /* Distance from the bottom */
        right: 10px; /* Distance from the right */
        z-index: 1000;
        max-width: 200px; /* Maximum width of the legend */
        font-family: Arial, sans-serif;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add shadow for a subtle effect */
    }

    #victimCounts h4 {
        margin: 0 0 5px; /* Margin for the heading */
        font-size: 16px; /* Font size for the heading */
        color: #333; /* Heading color */
    }

    #victimCounts p {
        display: flex; /* Use flexbox for alignment */
        align-items: center; /* Center items vertically */
        margin: 5px 0; /* Space between legend items */
        font-size: 14px; /* Font size for the text */
        color: #555; /* Text color */
    }

    #victimCounts span {
        font-weight: bold; /* Highlight the counts */
        margin-left: auto; /* Push the count to the right */
        color: #000; /* Dark color for the counts */
    }
</style>

</head>
<body>
  <?php
  include_once("../nav.php");
  ?>

  <!-- Controls Panel -->
  <div id="controls">
      <label for="blockX">Block X:</label>
      <input type="number" id="blockX" value="1" min="1">
      <label for="blockY">Block Y:</label>
      <input type="number" id="blockY" value="1" min="1">
      <label for="SpGroup">Species Group:</label>
      <select id="SpGroup">
          <option value="8" selected>All</option>
          <option value="1">Mersawa</option>
          <option value="2">Keruing</option>
          <option value="3">Dip Commercial</option>
          <option value="4">Dip NonCommercial</option>
          <option value="5">NonDip Commercial</option>
          <option value="6">NonDip NonCommercial</option>
          <option value="7">Others</option>
      </select>
      <label for="latitude">Latitude:</label>
      <input type="number" id="latitude" value="5.417965" step="0.000001">
      <label for="longitude">Longitude:</label>
      <input type="number" id="longitude" value="101.812081" step="0.000001">
      <button id="loadData">Load Data</button>
      <label for="treeNumber">Tree Number:</label>
      <input type="text" id="treeNumber" placeholder="Enter Tree Number">
      <button id="findTree">Find Tree</button>
  </div>

  <div id="legend" class="legend">
      <h4>Tree Species Legend</h4>
      <div>
          <img src="../icon/Mersawa.png" alt="Mersawa"> Mersawa
      </div>
      <div>
          <img src="../icon/Keruing.png" alt="Keruing"> Keruing
      </div>
      <div>
          <img src="../icon/DipCommercial.png" alt="Dip Commercial"> Dip Commercial
      </div>
      <div>
          <img src="../icon/DipNonCommercial.png" alt="Dip NonCommercial"> Dip NonCommercial
      </div>
      <div>
          <img src="../icon/NonDipCommercial.png" alt="NonDip Commercial"> NonDip Commercial
      </div>
      <div>
          <img src="../icon/NonDipNonCommercial.png" alt="NonDip NonCommercial"> NonDip NonCommercial
      </div>
      <div>
          <img src="../icon/Others.png" alt="Others"> Others
      </div>
      <div>
          <img src="../icon/V1.png" alt="V1"> Victim 1
      </div>
      <div>
          <img src="../icon/V2.png" alt="V2"> Victim 2
      </div>
      <div>
          <img src="../icon/Cut.png" alt="Cut"> Cut
      </div>
  </div>

  <div id="victimCounts">
  <h4>Victim Counts</h4>
  <p>Victim 1 Count: <span id="victim1Count">0</span></p>
  <p>Victim 2 Count: <span id="victim2Count">0</span></p>
    </div>

  <!-- Map Container -->
  <div id="map"></div>
  <script>
    let lat = 5.417965; // Default latitude
    let log = 101.812081; // Default longitude
    let rectangle = null; // Rectangle for the block

    async function fetchForestData(blockX, blockY, spGroup = null) {
      try {
        let url = `fetchdata.php?BlockX=${blockX}&BlockY=${blockY}`;
        if (spGroup !== null) {
          url += `&SpGroup=${spGroup}`;
        }
        const response = await fetch(url);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error fetching forest data:', error);
        return [];
      }
    }

    // Initialize map
    const map = L.map('map').setView([lat, log], 20); // Initial zoom level 20 for a detailed view
    
    // Add MapTiler tiles
    const apiKey = config.maptilerApiKey; // API key from config file
    L.tileLayer(`https://api.maptiler.com/maps/basic-v2/{z}/{x}/{y}.png?key=${apiKey}`, {
    attribution: '&copy; <a href="https://www.maptiler.com/">MapTiler</a>',
    maxZoom: 22 // Supports higher zoom levels
    }).addTo(map);

    function createRectangle(blockX, blockY) {
        // Calculate the new rectangle coordinates
        const blockLat = lat + (blockY - 1) * 100 * 0.000009;
        const blockLng = log + (blockX - 1) * 100 * 0.000009;

        // Rectangle dimensions in degrees
        const blockWidth = 100 * 0.000009;
        const blockHeight = 100 * 0.000009;

        // Rectangle boundaries
        const rectangleBounds = [
            [blockLat, blockLng], // Bottom Left
            [blockLat, blockLng + blockWidth], // Bottom Right
            [blockLat + blockHeight, blockLng + blockWidth], // Top Right
            [blockLat + blockHeight, blockLng] // Top Left
        ];

        // Remove the old rectangle if it exists
        if (rectangle) {
            map.removeLayer(rectangle);
        }

        // Create a new rectangle and add it to the map
        rectangle = L.polygon(rectangleBounds, {
            color: 'black',
            weight: 2,
            fillOpacity: 0
        }).addTo(map);

        // Calculate center of the rectangle
        const centerLat = blockLat + blockHeight / 2;
        const centerLng = blockLng + blockWidth / 2;

        // Center the map on the rectangle
        map.setView([centerLat, centerLng], 20);

        // Bind popup to the rectangle
        rectangle.bindPopup(`Block X: ${blockX}<br>Block Y: ${blockY}`);
    }

    let victim1Count = 0;
    let victim2Count = 0;

    function addTreeMarkers(trees) {

        victim1Count = 0;
        victim2Count = 0;

      const colors = {
          Cut: 'red',
          Keep: 'green',
          V1: 'yellow',
          V2: 'blue'
        };

      const icons = {
          1: L.icon({
              iconUrl: '../icon/Mersawa.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          }),
          2: L.icon({
              iconUrl: '../icon/Keruing.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          }),
          3: L.icon({
              iconUrl: '../icon/DipCommercial.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          }),
          4: L.icon({
              iconUrl: '../icon/DipNonCommercial.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          }),
          5: L.icon({
              iconUrl: '../icon/NonDipCommercial.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          }),
          6: L.icon({
              iconUrl: '../icon/NonDipNonCommercial.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          }),
          7: L.icon({
              iconUrl: '../icon/Others.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          }),
          V1: L.icon({
              iconUrl: '../icon/V1.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          }),
          V2: L.icon({
              iconUrl: '../icon/V2.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          }),
          Cut: L.icon({
              iconUrl: '../icon/Cut.png',
              iconSize: [20, 20],
              iconAnchor: [10, 20],
              popupAnchor: [0, -20]
          })
      };

      trees.forEach(tree => {
          const adjustedLat = lat + (tree.y * 0.000009);
          const adjustedLng = log + (tree.x * 0.000009);

          // Determine the icon based on the tree status
          let icon;
          if (tree.Status === 'Cut') {
                icon = icons['Cut'];
            } else if (tree.Status === 'V1') {
                icon = icons['V1'];
                victim1Count++; // Increment Victim 1 count
            } else if (tree.Status === 'V2') {
                icon = icons['V2'];
                victim2Count++; // Increment Victim 2 count
            } else {
                icon = icons[tree.spgroup];
                if (!icon) {
                    console.warn(`No icon found for spgroup: ${tree.spgroup }. Using default icon.`);
                    icon = icons[tree.spgroup];
                }
            }

          // Log the tree object and icon for debugging
          console.log(`Tree: ${JSON.stringify(tree)}, Icon: ${icon}`);

          // Create a marker for the tree using the appropriate icon
          const treeMarker = L.marker([adjustedLat, adjustedLng], {
              icon: icon
          }).addTo(map);

          // Bind popup to the marker
          treeMarker.bindPopup(`Tree Number: ${tree.TreeNumber || 'N/A'}<br>
                                Tree Status: ${tree.Status || 'Unknown'}<br>
                                Diameter: ${tree.diameter || 0} m<br>
                                Height: ${tree.StemHeight || 0} m<br>
                                Damage: ${tree.Damage || 0}<br>
                                Falling Angle: ${tree.Cut_Angle || 0}`);

          // Prevent the rectangle popup from showing when clicking on the tree marker
          treeMarker.on('click', function(e) {
              e.originalEvent.stopPropagation(); // Prevent the click event from bubbling up
              this.openPopup(); // Open the marker's popup
          });

          // If the tree is cut, draw the cut lines
            if (tree.Status === 'Cut') {
                // Convert Cut_Angle to clock perspective
                const adjustedCutAngle = (90 - tree.Cut_Angle + 360) % 360; // Convert to clock perspective
                const angleInRadians = tree.Cut_Angle * (Math.PI / 180); // Convert angle to radians
                const spreadInRadians = (1) * (Math.PI / 180); // Spread is 1 degree, so each side is 0.5 degree
                const lineLength = tree.StemHeight * 0.000009; // Length of the line in degrees (adjust as needed)

                // Calculate end points for the cut tree lines
                const endLat = adjustedLat + lineLength * Math.sin(angleInRadians);
                const endLng = adjustedLng + lineLength * Math.cos(angleInRadians);
                const endLat2 = adjustedLat + lineLength * Math.sin(angleInRadians + spreadInRadians);
                const endLng2 = adjustedLng + lineLength * Math.cos(angleInRadians + spreadInRadians);
                const endLat3 = adjustedLat + lineLength * Math.sin(angleInRadians - spreadInRadians);
                const endLng3 = adjustedLng + lineLength * Math.cos(angleInRadians - spreadInRadians);

                // Draw lines for the cut tree
                L.polyline([[adjustedLat, adjustedLng], [endLat, endLng]], {
                    color: colors['Cut'],
                    weight: 2
                }).addTo(map);
                L.polyline([[adjustedLat, adjustedLng], [endLat2, endLng2]], {
                    color: colors['Cut'],
                    weight: 2
                }).addTo(map);
                L.polyline([[adjustedLat, adjustedLng], [endLat3, endLng3]], {
                    color: colors['Cut'],
                    weight: 2
                }).addTo(map);
                L.circle([endLat, endLng], {
                    radius: 5, // Radius in meters
                    color: 'blue', // Circle color
                    fillColor: 'blue', // Fill color
                    fillOpacity: 0 // Fill opacity
                }).addTo(map);
            }
      });

      updateVictimCounts();
    }

    function updateVictimCounts() {
        document.getElementById('victim1Count').textContent = victim1Count;
        document.getElementById('victim2Count').textContent = victim2Count;
    }
    
    function addGridLines() {
      if (!rectangle) return; // Ensure the rectangle exists

      const bounds = rectangle.getBounds(); // Get the rectangle's boundaries
      const startLat = bounds.getSouth(); // Bottom edge latitude
      const endLat = bounds.getNorth(); // Top edge latitude
      const startLng = bounds.getWest(); // Left edge longitude
      const endLng = bounds.getEast(); // Right edge longitude

      const gridInterval = 10 * 0.000009; // Convert grid interval to degrees (10m)

      // Draw vertical grid lines within the rectangle
      for (let lng = startLng; lng <= endLng; lng += gridInterval) {
        L.polyline([[startLat, lng], [endLat, lng]], {
          color: 'black',
          weight: 1,
          dashArray: '5, 5' // Dashed line
        }).addTo(map);
      }

      // Draw horizontal grid lines within the rectangle
      for (let lat = startLat; lat <= endLat; lat += gridInterval) {
        L.polyline([[lat, startLng], [lat, endLng]], {
          color: 'black',
          weight: 1,
          dashArray: '5, 5' // Dashed line
        }).addTo(map);
      }
    }

    function findTreeMarker(treeNumber) {
    // Clear any existing highlights
    map.eachLayer(layer => {
        if (layer instanceof L.Marker) {
            // Reset the icon to the original one (you may want to store the original icon)
            layer.setIcon(layer.originalIcon || layer.options.icon); // Reset to original icon
        }
    });

    // Find the tree marker with the specified TreeNumber
    let found = false; // Flag to check if the tree is found
    map.eachLayer(layer => {
        if (layer instanceof L.Marker && layer.getPopup()) {
            const popupContent = layer.getPopup().getContent();
            if (popupContent.includes(`Tree Number: ${treeNumber}`)) {
                // Highlight the found tree marker
                const originalIcon = layer.options.icon; // Store the original icon
                layer.originalIcon = originalIcon; // Save the original icon for resetting later
                layer.setIcon(L.icon({ // Change the icon to indicate selection
                    iconUrl: '../icon/Cut.png', // Use a different icon for highlighting
                    iconSize: [20, 20],
                    iconAnchor: [10, 20],
                    popupAnchor: [0, -20]
                }));
                layer.openPopup(); // Open the popup for the found tree
                map.setView(layer.getLatLng(), 20); // Center the map on the found tree
                found = true; // Set found flag to true
            }
        }
    });

    if (!found) {
        alert(`Tree Number ${treeNumber} not found.`);
    }
}

    // Event listener for Load Data button
    document.getElementById('loadData').addEventListener('click', () => {
      const blockX = document.getElementById('blockX').value;
      const blockY = document.getElementById('blockY').value;
      const spGroup = document.getElementById('SpGroup').value;
      const inputLat = parseFloat(document.getElementById('latitude').value);
      const inputLng = parseFloat(document.getElementById('longitude').value);

      if (!isNaN(inputLat) && !isNaN(inputLng)) {
        lat = inputLat; // Update latitude
        log = inputLng; // Update longitude
      }

      fetchForestData(blockX, blockY, spGroup).then(trees => {
        if (trees.length === 0) {
          alert(`No data found for Block X: ${blockX}, Block Y: ${blockY}, Species Group: ${spGroup}`);
          return;
        }

        // Clear existing layers, but exclude the rectangle
        map.eachLayer(layer => {
          if (
            layer !== rectangle && // Exclude the rectangle
            (layer instanceof L.Marker ||
            layer instanceof L.CircleMarker ||
            layer instanceof L.Polyline)
          ) {
            map.removeLayer(layer);
          }
        });

        // Create or update the rectangle
        createRectangle(blockX, blockY);

        // Add tree markers to the map
        addTreeMarkers(trees);
        addGridLines();
      });
    });

    // Load initial data
    fetchForestData(1, 1).then(trees => {
      createRectangle(1, 1); // Center map on the initial rectangle
      addTreeMarkers(trees);
      addGridLines();
    });

    document.getElementById('findTree').addEventListener('click', () => {
        const treeNumber = document.getElementById('treeNumber').value.trim();
        if (treeNumber) {
            findTreeMarker(treeNumber);
        } else {
            alert('Please enter a Tree Number.');
        }
    });
  </script>
</body>


</html>
