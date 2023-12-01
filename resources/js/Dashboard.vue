<template>
  <header class="bg-info text-center py-3">
    <h1 class="fw-bold h3 text-white my-1">Weather Dashboard</h1>
  </header>

  <div class="px-2 my-4 row g-3 justify-content-center col-sm-10 col-md-7 mx-auto">
    <div class="p-0">
      <h5 class="fw-bold">Find Location</h5>
      <form class="position-relative">

        <!-- user input -->
        <input @keyup="checkCity" v-model="form.city" name="city" type="text" id="city-input"
               class="py-2 form-control"
               placeholder="Search Places" autocomplete="off"/>

        <!-- loader -->
        <div class="spinner-border text-secondary loader" role="status" v-if="form.showspinner">
          <span class="visually-hidden">Loading...</span>
        </div>

        <!-- show error -->
        <div id="apiError" class="form-text text-danger" v-if="apiError">{{ apiError }}</div>

        <InputAutoComplete :form="form" @select-city="selectCity"></InputAutoComplete>

      </form>
    </div>

    <TodayBlock :today=today></TodayBlock>
    <ForeCast :showData="showData"
             :fiveDaysForecastData="fiveDaysForecastData"
    ></ForeCast>
    <RelatedPlaces :showData="showData" :relatedPlaces="relatedPlaces"></RelatedPlaces>


  </div>
</template>
<script setup>
import axios from "axios";
import {reactive, ref, onMounted} from 'vue'
import debounce from 'lodash.debounce'

import TodayBlock from "./components/TodayBlock.vue";
import ForeCast from "./components/ForeCast.vue";
import InputAutoComplete from "./components/InputAutoComplete.vue";
import RelatedPlaces from "./components/RelatedPlaces.vue";

const apiError = ref(false);
const fiveDaysForecastData = ref([]);
const showData = ref(false);
const relatedPlaces = ref([]);

const today = reactive({
  city: null,
  date: null,
  temp: null,
  wind: null,
  humid: null,
  weatherDescription: null,
  weatherIcon: null
})

const form = reactive({
  city: null,
  autocomplete: null,
  lat: null,
  lon: null,
  hideAutoComplete: false,
  showspinner: false
})

//Load current geolocation of User
const currentLocation = () => {
  //do we support geolocation
  if (!("geolocation" in navigator)) {
    console.log('Geolocation is not available.');
  }

  // get html5 current geolocation
  navigator.geolocation.getCurrentPosition(pos => {
    form.lat = pos.coords.latitude;
    form.lon = pos.coords.longitude;

    axios.post('/api/get/current/city', form)
        .then((resposnse) => {
          today.city = resposnse.data.name;
          today.temp = resposnse.data.main.temp
          today.date = new Date();
          today.humid = resposnse.data.main.humidity
          today.wind = resposnse.data.wind.speed;
          today.weatherDescription = resposnse.data.weather[0].description;
          today.weatherIcon = resposnse.data.weather[0].icon;
        }).catch((error) => {
      apiError.value = error;
    })

  }, err => {
    apiError.value = true;
  })


}

//Selected city
const selectCity = (data) => {
  form.city = data.city ? data.city : data.country;
  form.lon = data.lon;
  form.lat = data.lat;
  form.hideAutoComplete = false;

  axios.post('/api/get/city', form)
      .then((resposnse) => {

        const forecastArray = resposnse.data;
        const uniqueForecastDays = new Set();

        //Get only 5 days filter data
        const fiveDaysForecast = forecastArray.filter(forecast => {
          const forecastDate = new Date(forecast.dt_txt).getDate();
          if (!uniqueForecastDays.has(forecastDate) && uniqueForecastDays.size < 5) {
            uniqueForecastDays.add(forecastDate);
            return true;
          }
          return false;
        });

        //Set today weather
        if (fiveDaysForecast) {
          var CurrentDate = fiveDaysForecast[0].dt_txt;
          CurrentDate = CurrentDate.split(' ')[0];

          today.city = form.city ? form.city : form.country;
          today.date = CurrentDate;
          today.temp = fiveDaysForecast[0].main['temp'];
          today.wind = fiveDaysForecast[0].wind.speed;
          today.humid = fiveDaysForecast[0].main['humidity'];
          today.weatherDescription = fiveDaysForecast[0].weather[0].description;
          today.weatherIcon = fiveDaysForecast[0].weather[0].icon;
        }

        fiveDaysForecastData.value = fiveDaysForecast.slice(1);
        showData.value = true;

        //get related places
        getRelatedPlacces();

      }).catch((error) => {
    apiError.value = error;
  })
}

//Get dropdown city's
const checkCity = debounce(() => {
  form.showspinner = true;
  axios.get('/api/get/city/' + form.city)
      .then((resposnse) => {
        if (resposnse.data === 'error') {
          apiError.value = 'Address Not Found!';
          form.showspinner = false;
        } else {
          form.autocomplete = resposnse.data;
          form.hideAutoComplete = true;
          form.showspinner = false;
          apiError.value = false;
        }
      }).catch((error) => {
    apiError.value = error;
  })
}, 700)

const getRelatedPlacces = () => {
  axios.post('api/get/related/places', form)
      .then((resposnse) => {
        relatedPlaces.value = resposnse.data
      }).catch((error) => {
    apiError.value = error;
  })
}

const formatDate = (date) => {
  var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  var d = new Date(date);
  return days[d.getDay()];
}

onMounted(() => {
  currentLocation();
});

</script>
