<template>
  <div class="card text-left">
    <div
      class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
    >
      <h6 class="m-0 font-weight-bold text-primary">STORE NAME:</h6>
      <div class="dropdown no-arrow">
        <ul class="list-inline mb-0">
          <li class="list-inline-item">Select Date:</li>
          <li class="list-inline-item">
            <input
              type="date"
              @change="onSelectDate"
              v-model="selectedDate"
              class="form-control"
            />
          </li>
        </ul>
      </div>
    </div>

    <div class="card-body">
      <h4 class="mb-0">Store hours :</h4>
      <ul class="list-inline mb-0" v-for="(time, index) in times" :key="index">
        <li class="list-inline-item text-capitalize text-primary">
          {{ time.day }}
        </li>
        <li class="list-inline-item text-capitalize">at</li>
        <li class="list-inline-item">
          {{ time.open_time }} - {{ time.close_time }}
        </li>
        <li class="list-inline-item">
          <strong class="text-primary">Lunch Break:</strong>
          {{ time.lunch_start }} -
          {{ time.lunch_end }}
        </li>
        <li class="list-inline-item">
          <a href="#" @click.prevent="changeTime(time)">
            <i class="fa fa-edit" aria-hidden="true"></i>
          </a>

          <a href="#" class="ml-2 text-danger" @click.prevent="onDelete(time)">
            <i class="fa fa-trash" aria-hidden="true"></i>
          </a>
        </li>
      </ul>
      <hr />
      <h4 class="card-title">
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
      </h4>
      <p class="card-text text-capitalize" v-if="item.next_opening">
        Next Open <strong> {{ item.next_opening }}</strong>
      </p>
    </div>

    <b-modal
      v-if="isModalShow"
      :id="`edit-modal`"
      hide-footer
      :title="`Update Store Time: ${selectedItem.day.toUpperCase()}`"
    >
      <form action="#" @submit.prevent="onSubmit">
        <div class="form-group">
          <label for="">Day</label>
          <b-form-select v-model="form.day" :options="days"></b-form-select>
        </div>
        <hr />

        <div class="form-group">
          <div class="row">
            <div class="col">
              <label for="">Open Time</label>
              <p>
                <b-time v-model="form.open_time" locale="en"></b-time>
              </p>
            </div>
            <div class="col">
              <label for="">Close Time</label>
              <p>
                <b-time v-model="form.close_time" locale="en"></b-time>
              </p>
            </div>
          </div>
        </div>
        <hr />
        <div class="form-group">
          <div class="row">
            <div class="col">
              <label for="">Lunch Start</label>
              <p>
                <b-time v-model="form.lunch_start" locale="en"></b-time>
              </p>
            </div>
            <div class="col">
              <label for="">Lunch End</label>
              <p>
                <b-time v-model="form.lunch_end" locale="en"></b-time>
              </p>
            </div>
          </div>
        </div>
        <hr />

        <div class="float-right">
          <b-button type="submit"> Update </b-button>
        </div>
      </form>
    </b-modal>
  </div>
</template>

<script>
import axios from "axios";
import Form from "./../../helpers/form";

export default {
  data() {
    return {
      selectedItem: {},
      selectedDate: "",
      isModalShow: false,
      item: {},
      times: [],
      days: [
        "monday",
        "tuesday",
        "wednesday",
        "thursday",
        "friday",
        "saturday",
        "sunday",
      ],
      form: new Form({
        id: "",
        day: "",
        open_time: "",
        close_time: "",
        lunch_start: "",
        lunch_end: "",
      }),
    };
  },
  mounted() {
    this.getOpenHours();
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

    getOpenHours() {
      axios.get("/api/working-hours/").then((resp) => {
        this.times = resp.data.data;
      });
    },

    onSelectDate() {
      this.getWorkingHours();
    },

    changeTime(item) {
      this.isModalShow = true;
      this.selectedItem = item;
      this.form.id = item.id;
      this.form.day = item.day;
      this.form.open_time = item.open_time;
      this.form.close_time = item.close_time;
      this.form.lunch_start = item.lunch_start;
      this.form.lunch_end = item.lunch_end;

      setTimeout(() => {
        this.$bvModal.show(`edit-modal`);
      }, 400);
    },

    onDelete(item) {
      axios
        .delete("/api/working-hours/status", {
          params: {
            id: item.id,
          },
        })
        .then((resp) => {
          this.getOpenHours();
          this.getWorkingHours();
        });
    },

    hideModal() {},

    onSubmit() {
      let params = {
        id: this.form.id,
        day: this.form.day,
        open_time: this.form.open_time,
        close_time: this.form.close_time,
        lunch_start: this.form.lunch_start,
        lunch_end: this.form.lunch_end,
      };

      axios.post("/api/working-hours/status", params).then((resp) => {
        this.getOpenHours();
        this.getWorkingHours();

        this.$bvModal.hide(`edit-modal`);
      });
    },
  },
};
</script>
