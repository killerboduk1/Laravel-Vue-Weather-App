<template>
  <div class="current-weather bg-info text-white py-2 px-4 rounded-3">
    <div class="mt-3 d-flex justify-content-between">
      <div>
        <h3 class="fw-bold">{{ today.city }} - {{ formatDate(today.date) }}</h3>
        <h6 class="my-3 mt-3">Date: {{ today.date }}</h6>
        <h6 class="my-3 mt-3">Temperature: {{ today.temp }}°C</h6>
        <h6 class="my-3">Wind: {{ today.wind }} M/S</h6>
        <h6 class="my-3">Humidity: {{ today.humid }}%</h6>
      </div>
      <div class="text-center me-lg-5">
        <img src="https://openweathermap.org/img/wn/04d@2x.png" alt="weather icon" v-if="today.weatherIcon">
        <img src="https://openweathermap.org/img/wn/04d@2x.png" alt="weather icon" v-else>
        <h6>{{ today.weatherDescription }}</h6>
      </div>
    </div>
  </div>
</template>
<script setup>
defineProps({
  today: Object
})

const formatDate = (date) => {
  var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  var d = new Date(date);
  return days[d.getDay()];
}
</script>
