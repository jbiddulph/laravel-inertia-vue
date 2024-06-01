<template>
  <Head title="Register" />
  <h1 class="title">Report an item</h1>
  <div class="w-1/4 mx-auto bg-slate-100 p-3 rounded-lg">
    <form @submit.prevent="submit">
      <div class="grid place-items-center">
        <div class="relative w-28 h-28 rounded-full overflow-hidden border border-slate-300">
          <label for="item_pic" class="absolute inset-0 grid content-end cursor-pointer">
            <span class="bg-white/70 pb-2 text-center">Item Pic</span>
          </label>
          <input type="file" @input="changePic" id="item_pic" hidden>
          <img class="object-cover w-28 h-28" :src="form.preview ?? '/storage/avatars/default.jpg'" />
        </div>
        <p class="error mt-t">{{ form.errors.item_pic }}</p>
      </div>
      <TextInput name="Name" v-model="form.item_name" :message="form.errors.item_name" />
      <TextInput name="Description" v-model="form.item_description" :message="form.errors.item_description" />
      <!-- Status dropdown -->
        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <select id="status" v-model="form.item_status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option v-for="status in statuses" :key="status">{{ status }}</option>
          </select>
          <p class="error mt-t">{{ form.errors.item_status }}</p>
        </div>
        
        <!-- Type dropdown -->
        <div>
          <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
          <select id="type" v-model="form.item_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option v-for="type in typesMap[form.item_status]" :key="type">{{ type }}</option>
          </select>
          <p class="error mt-t">{{ form.errors.item_type }}</p>
        </div>
      <div id="layout">
        <Map @update:coordinates="updateCoordinates" />
      </div>
      <TextInput name="Latitude" v-model="form.latitude" :message="form.errors.latitude" />
      <TextInput name="Longitude" v-model="form.longitude" :message="form.errors.longitude" />
      <TextInput name="Date" type="date" v-model="form.reported_date" :message="form.errors.reported_date" />
      <TextInput name="Time" type="time" v-model="form.reported_time" :message="form.errors.reported_time" />
      <div>
        <button class="primary-btn" :disabled="form.processing">Report</button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import Map from '../../Components/Map.vue';
import 'mapbox-gl/dist/mapbox-gl.css';
import TextInput from '../../Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Define the form and its initial values
const form = useForm({
  item_name: null,
  item_description: null,
  item_status: null,
  item_type: null,
  latitude: null,
  longitude: null,
  reported_date: null,
  reported_time: null,
  item_pic: null,
  preview: null,
});
const statuses = ['Lost', 'Found', 'Report'];
const typesMap = {
  Lost: ['Electronics', 'Clothing', 'Jewelry', 'Other'],
  Found: ['Electronics', 'Clothing', 'Jewelry', 'Other'],
  Report: ['Incident', 'Complaint', 'Suggestion', 'Pothole', 'Sinkhole', 'Trip Hazard', 'Crime', 'Theft', 'Disturbance', 'Danger', 'Crash', 'Dog Poop', 'UFO']
};
// Define the changePic method to handle file input change
const changePic = (e: Event) => {
  const input = e.target as HTMLInputElement;
  if (input.files && input.files[0]) {
    form.item_pic = input.files[0];
    form.preview = URL.createObjectURL(input.files[0]);
  }
};

// Define the submit method to handle form submission
const submit = () => {
  form.post(route('itemCreate'));
};

// Update the form's latitude and longitude when the map coordinates change
const updateCoordinates = ({ lng, lat }) => {
  form.latitude = lat;
  form.longitude = lng;
};
</script>

<style scoped>
#layout {
  flex: 1;
  display: flex;
  position: relative;
}
</style>
