<template>
  <h4 class="fw-bold my-4" v-if="showData">4-Day Forecast</h4>

  <div class="days-forecast row px-0 justify-content-between">
    <div class="col md-3 py-3" v-for="city in fiveDaysForecastData" :key="city.id">
      <div class="card border-0 bg-secondary text-black">
        <div class="card-body p-3 text-white bg-info text-center rounded-3">
          <h6 class="card-title fw-semibold">{{ formatDate(city.dt_txt) }}</h6>
          <img v-bind:src="'https://openweathermap.org/img/wn/' + city.weather[0].icon +'.png'"
               alt="weather icon">
          <h6 class="card-text my-3 mt-3">Temp: {{ city.main.temp }}°C</h6>
          <h6 class="card-text my-3">Wind: 5.52 M/S</h6>
          <h6 class="card-text my-3">Humidity: 80%</h6>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
defineProps({
  showData: false,
  fiveDaysForecastData: Array
})

const formatDate = (date) => {
  var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  var d = new Date(date);
  return days[d.getDay()];
}
</script>
