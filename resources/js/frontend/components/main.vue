<template>
  <div class="card">
    <div class="card-body text-center p-5">
      <div class="row d-flex justify-content-center">
        <div class="col-md-6">
          <h3>Select Date</h3>
          <input
            type="date"
            @change="onSelectDate"
            v-model="selectedDate"
            class="form-control-lg"
          />
        </div>
      </div>

      <!-- {{ item }} -->

      <br />
      <br />
      <br />
      <h2 class="card-title">
        Store Is
        <strong
          class="text-uppercase"
          :class="{
            'text-danger': item.status === 'closed',
            'text-success': item.status === 'open',
          }"
        >
          {{ item.status }}
        </strong>
      </h2>
      <p class="card-text text-capitalize" v-if="item.next_opening">
        Next Open on <strong> {{ item.next_opening }}</strong>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedDate: "",
      item: {},
    };
  },

  mounted() {
    // this.getOpenHours();
    this.getWorkingHours();
  },

  methods: {
    getWorkingHours() {
      axios
        .get("/api/working-hours/status", {
          params: {
            selectedDate: this.selectedDate,
          },
        })
        .then((resp) => {
          this.item = resp.data.data;
        });
    },

    onSelectDate() {
      this.getWorkingHours();
    },
  },
};
</script>

<style>
</style>
