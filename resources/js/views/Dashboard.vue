<template>
	<v-container fluid>
		<v-card class="mb-3">
			<v-card-title>{{ $t('Dashboard') }}</v-card-title>
		</v-card>
        <v-row>
      <v-col lg="7" cols="12">
        <v-row>

          <v-col sm="6" md="4" cols="12">
            <v-card color="blue lighten-1" :to="{ name: 'category.index' }">
               <v-list-item-content class="pt-5">
                <v-avatar rounded="0">
                  <v-icon color="white" size="60">mdi-shape-outline</v-icon>
                </v-avatar>
              </v-list-item-content>
              <v-list-item-subtitle class="text-center text--white ma-1" style="color: white;">
                Total Categories
              </v-list-item-subtitle>
              <v-list-item-title class="text-center text-h5 pb-5" style="color: white;">
                {{data[0] ? data[0].length : '00'}}
              </v-list-item-title>
            </v-card>
          </v-col>

          <v-col sm="6" md="4" cols="12">
            <v-card color="green lighten-1" :to="{ name: 'crop.index' }">
              <v-list-item-content class="pt-5">
                <v-avatar rounded="0">
                  <v-icon color="white" size="80">mdi-grass</v-icon>
                </v-avatar>
              </v-list-item-content>
              <v-list-item-subtitle class="text-center text--white ma-1" style="color: white;">
                Total Crops
              </v-list-item-subtitle>
              <v-list-item-title class="text-center text-h5 pb-5" style="color: white;">
                {{data[1] ? data[1].length : '00'}}
              </v-list-item-title>
            </v-card>
          </v-col>


          <v-col sm="6" md="4" cols="12">
            <v-card color="red lighten-1" :to="{ name: 'disease.index' }">
              <v-list-item-content class="pt-5">
                <v-avatar rounded="0">
                  <v-icon color="white" size="80">mdi-memory</v-icon>
                </v-avatar>
              </v-list-item-content>
              <v-list-item-subtitle class="text-center text--white ma-1" style="color: white;">
                Total Diseases
              </v-list-item-subtitle>
              <v-list-item-title class="text-center text-h5 pb-5" style="color: white;">
                {{data[2] ? data[2].length : '00'}}
              </v-list-item-title>
            </v-card>
          </v-col>


          <v-col sm="6" md="4" cols="12">
            <v-card color="purple lighten-1" :to="{ name: 'condition.index' }">
               <v-list-item-content class="pt-5">
                <v-avatar rounded="0">
                  <v-icon color="white" size="80">mdi-folder-wrench-outline</v-icon>
                </v-avatar>
              </v-list-item-content>
              <v-list-item-subtitle class="text-center text--white ma-1" style="color: white;">
                Total Condition
              </v-list-item-subtitle>
              <v-list-item-title class="text-center text-h5 pb-5" style="color: white;">
                {{data[3] ? data[3].length : '00'}}
              </v-list-item-title>
            </v-card>
          </v-col>




          <v-col sm="6" md="4" cols="12">
            <v-card color="blue darken-3" :to="{ name: 'activity.index' }">
               <v-list-item-content class="pt-5">
                <v-avatar rounded="0">
                  <v-icon color="white" size="80">mdi-account-school</v-icon>
                </v-avatar>
              </v-list-item-content>
              <v-list-item-subtitle class="text-center text--white ma-1" style="color: white;">
                Total Guide
              </v-list-item-subtitle>
              <v-list-item-title class="text-center text-h5 pb-5" style="color: white;">
                {{data[5] ? data[5].length : '00'}}
              </v-list-item-title>
            </v-card>
          </v-col>

          <v-col sm="6" md="4" cols="12">
            <v-card color="orange lighten-1" :to="{ name: 'user.index' }">
               <v-list-item-content class="pt-5">
                <v-avatar rounded="0">
                  <v-icon color="white" size="80">mdi-account-group</v-icon>
                </v-avatar>
              </v-list-item-content>
              <v-list-item-subtitle class="text-center text--white ma-1" style="color: white;">
                Total Users
              </v-list-item-subtitle>
              <v-list-item-title class="text-center text-h5 pb-5" style="color: white;">
                <!-- {{data[4]?.length}} -->
                {{data[4] ? data[4].length : '00'}}
              </v-list-item-title>
            </v-card>
          </v-col>

        </v-row>
      </v-col>
      <v-col lg="5" cols="12">
        <v-card height="340px">

            <!-- <v-row class="mt-1">
                <v-col>
                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 52"><title>Logomark</title><path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.646 2.675v9.124l8.01-4.611zm-9.61 16.505v-9.13l-4.57 2.61-13.05 7.448v9.216l17.62-10.144zM1.602 7.719v31.068L19.22 48.93v-9.214l-9.204-5.209-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.012-.078-.016-.117-.004-.03-.012-.06-.012-.09v-.002-21.481L4.965 9.654 1.602 7.72zm8.81-5.994L2.405 6.334l8.005 4.609 8.006-4.61-8.006-4.608zm4.164 28.764l4.645-2.674V7.719l-3.363 1.936-4.646 2.675v20.096l3.364-1.937zM39.243 7.164l-8.006 4.609 8.006 4.609 8.005-4.61-8.005-4.608zm-.801 10.605l-4.646-2.675-3.363-1.936v9.124l4.645 2.674 3.364 1.937v-9.124zM20.02 38.33l11.743-6.704 5.87-3.35-8-4.606-9.211 5.303-8.395 4.833 7.993 4.524z" fill="#FF2D20" fill-rule="evenodd"/></svg>
                </v-col>
                <v-col>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 261.76 226.69"><path d="M161.096.001l-30.225 52.351L100.647.001H-.005l130.877 226.688L261.749.001z" fill="#41b883"/><path d="M161.096.001l-30.225 52.351L100.647.001H52.346l78.526 136.01L209.398.001z" fill="#34495e"/></svg>
                </v-col>
            </v-row> -->

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.2037761237634!2d103.2175429152514!3d13.086268115891388!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3105499fe765395f%3A0xafe041b8dd5dbb8a!2zTmF0aW9uYWwgVW5pdmVyc2l0eSBvZiBCYXR0YW1iYW5nIC8g4Z6f4Z624Z6A4Z6b4Z6c4Z634Z6R4Z-S4Z6Z4Z624Z6b4Z-Q4Z6Z4oCL4Z6H4Z624Z6P4Z634Z6U4Z624Z6P4Z-L4Z6K4Z-G4Z6U4Z6E!5e0!3m2!1sen!2skh!4v1664024666430!5m2!1sen!2skh" style="width: 100%; border: 0; height: 100%;"  allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        </v-card>
      </v-col>
    </v-row>
      <v-row>
        <v-col class="text-center mt-3">
            <a href="/api/dashboardExport" style="text-decoration: none;">
                <v-btn color="success">
                    Download Plant Helper Summary
                </v-btn>
            </a>
            <!-- <v-btn :loading="exporting" @click="onExport()" class="mx-5" color="success"><v-icon left >mdi-download</v-icon>Download Plant Helper Summary</v-btn> -->
        </v-col>
      </v-row>
      <v-row class="my-3">

        <v-col md="4" sm="12">
            <v-card>
                <v-card-title>Crop Category Statistic</v-card-title>
                <v-divider/>
                <apexchart width="400px" type="bar" :options="chartOptions1" :series="series1"></apexchart>
            </v-card>
        </v-col>
        <v-col md="4" sm="12">
            <v-card>
                <v-card-title>Guide Statistic</v-card-title>
                <v-divider/>
                <apexchart type="donut" width="400px" :options="chartOptions2" :series="series2"></apexchart>
            </v-card>
        </v-col>
        <v-col md="4" sm="12">
            <v-card>
                <v-card-title>Disease Statistic</v-card-title>
                <v-divider/>
                <apexchart type="donut" width="400px" :options="chartOptions3" :series="series3"></apexchart>
            </v-card>
        </v-col>
      </v-row>
	</v-container>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import constants from '../constants'
import axiosApiInstance from '../utilites'
export default {
    data: () => ({
        storagePath: constants.storagePath,
        loading: true,
        exporting: false,
        data: [],
        chartOptions1: {
            dataLabels: {
                enabled: true
            },
            xaxis: {
                categories: [
                    // 121321, 23121,3122,231213
                ]
            },
        },
        series1: [
            {
                name: '',
                data: [
                    // 231,231,231
                ]
            }
        ],

        chartOptions2: {
            labels: [

            ],
            chart: {
              type: 'donut',
            },
            responsive: [{
                breakpoint: 300,
                options: {
                    chart: {
                        width: 150
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        },
        series2: [

        ],

        chartOptions3: {
            labels: [

            ],
            chart: {
              type: 'donut',
            },
            responsive: [{
                breakpoint: 300,
                options: {
                    chart: {
                        width: 150
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        },
        series3: [

        ],

    }),

    mounted() {
        this.fetchData();
        this.fetchCategoryChart();
        this.fetchDiseaseChart();
        this.fetchGuideChart()

    },
    watch: {
    series: function (newSeries, oldSeries) {
      this.$refs.chart.updateSeries(newSeries)
    }
  },
    methods: {
        fetchData() {
            axiosApiInstance.get("/dashboard")
                .then((response) => {
                this.data = response.data;
                // console.log(this.data[2]);
            })
                .catch(({ response }) => {
                this.$store.dispatch("pushNotification", { message: response.data.message, type: "error" });
            });
        },
        async fetchCategoryChart() {
            axiosApiInstance.get("/categoryChart")
            .then((response) => {

                this.chartOptions1.xaxis.categories = response.data[0].map(it => it.name)
                // this.series3[0].name = response.data[0].map(it => it.name)
                this.series1[0].data = response.data[1].map(it => it.crop_count)
                // console.log(this.chartOptions1.xaxis.categories);
                // console.log(this.series1[0].data);
            })
            .catch(({ response }) => {
                this.$store.dispatch("pushNotification", { message: response.data.message, type: "error" });
           });
        },

        fetchGuideChart() {
            axiosApiInstance.get("/guideChart")
            .then((response) => {

                this.chartOptions2.labels = response.data[0].map(it => it.name)
                this.series2 = response.data[1].map(it => it.activity_count)
            })
            .catch(({ response }) => {
                this.$store.dispatch("pushNotification", { message: response.data.message, type: "error" });
           });
        },

        fetchDiseaseChart() {
            axiosApiInstance.get("/diseaseChart")
            .then((response) => {

                this.chartOptions3.labels = response.data[0].map(it => it.name)
                this.series3 = response.data[1].map(it => it.disease_count)
            })
            .catch(({ response }) => {
                this.$store.dispatch("pushNotification", { message: response.data.message, type: "error" });
           });
        },
        onExport()
        {
            this.exporting = true
            axiosApiInstance.get('dashboardExport', {
                headers: {
                    responseType: 'blob',
                }
            })
            .then(response => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');

                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'planthelpersummary.xlsx');
                document.body.appendChild(fileLink);
                fileLink.click();
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'success' })
            })
            .catch(({ response }) => {
                this.$store.dispatch('pushNotification', { message: response.data.message, type: 'error' })
            })
            .finally(() => {
                this.exporting = false
            })
        }
    },

}
</script>
