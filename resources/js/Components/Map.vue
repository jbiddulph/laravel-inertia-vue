<template>
  <div>
    <div id="sidebar">Longitude: {{ location.lng }} | Latitude: {{ location.lat }} | Zoom: {{ location.zoom }}</div>
    <div ref="mapContainer" class="map-container">
      <!-- Add crosshair element -->
      <div class="crosshair"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
import mapboxgl from 'mapbox-gl';
import { onMounted, onUnmounted, ref, reactive } from 'vue';

// Set the Mapbox access token
mapboxgl.accessToken = 'pk.eyJ1IjoiamJpZGR1bHBoIiwiYSI6ImNscDgzemt0ZzJjNW8ydnM0MXJvNG56NjEifQ.h0CNNEv-Yjgkp4WMjOK9mA';

// Define a ref to hold the map instance
const map = ref<mapboxgl.Map | null>(null);
// Define a ref to hold the map container element
const mapContainer = ref<HTMLDivElement | null>(null);
// Define reactive properties for location
const location = reactive({
  lng: -0.392432,
  lat: 50.819092,
  zoom: 16
});

// Emit event for updated coordinates
const emit = defineEmits(['update:coordinates']);

// Function to get user's current location
const getUserLocation = () => {
  return new Promise<{ longitude: number; latitude: number }>((resolve, reject) => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        position => {
          resolve({
            longitude: position.coords.longitude,
            latitude: position.coords.latitude
          });
        },
        error => {
          reject(error);
        }
      );
    } else {
      reject(new Error('Geolocation is not supported by this browser.'));
    }
  });
};

// Setup the map on component mount
onMounted(async () => {
  try {
    const userLocation = await getUserLocation();
    location.lng = userLocation.longitude;
    location.lat = userLocation.latitude;

    if (mapContainer.value) {
      map.value = new mapboxgl.Map({
        container: mapContainer.value,
        style: 'mapbox://styles/mapbox/streets-v12', // Replace with your preferred map style
        center: [location.lng, location.lat],
        zoom: location.zoom
      });

      // Update reactive location when map moves
      map.value.on('move', () => {
        const { lng, lat } = map.value.getCenter();
        const zoom = map.value.getZoom();
        location.lng = lng.toFixed(6);
        location.lat = lat.toFixed(6);
        location.zoom = zoom.toFixed(2);

        // Emit the coordinates change event
        emit('update:coordinates', {
          lng: location.lng,
          lat: location.lat,
        });
      });

      // Add crosshair to map
      const crosshair = document.createElement('div');
      crosshair.className = 'crosshair';
      mapContainer.value.appendChild(crosshair);
    }
  } catch (error) {
    console.error('Error getting user location:', error);
  }
});

// Cleanup the map on component unmount
onUnmounted(() => {
  if (map.value) {
    map.value.remove();
    map.value = null;
  }
});
</script>

<style scoped>
.map-container {
  height: 290px; /* Ensure the map container has a height */
  width: 290px;
  display: block;
  flex: 1;
  position: relative;
}

#sidebar {
  background-color: rgb(35 55 75 / 90%);
  color: #fff;
  padding: 6px 12px;
  font-family: monospace;
  font-size: 0.6rem;
  z-index: 1;
  position: absolute;
  top: 0;
  left: 0;
  margin: 12px;
  border-radius: 4px;
}

/* Style for crosshair */
.crosshair {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 20px;
  height: 20px;
  border: 2px solid #c80000;
  border-radius: 50%;
  pointer-events: none; /* To prevent crosshair from interfering with map interaction */
  z-index: 1; /* Ensure crosshair is above the map */
}
</style>
