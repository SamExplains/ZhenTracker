<template>
  <div>
    <div class="form-group mt-3">
      <input
        :id="id"
        :value="returnYear"
        class="form-control mt-2"
        type="text"
        placeholder="Select Date.."
        @change="updateCalendarInputValue"
      />
    </div>
  </div>
</template>

<script>
import flatpickr from "flatpickr";

export default {
  props: {
    timeFormat: String,
    id: String,
    fontSize: String,
    default: String,
  },
  data() {
    return {
      calendarYear: "today",
    };
  },
  mounted() {
    flatpickr(`#${this.id}`, {
      enableTime: false,
      dateFormat: this.timeFormat,
      defaultDate: this.default !== "" ? this.default : Date.now(),
    });
  },
  methods: {
    updateCalendarInputValue: function (event) {
      // console.warn(event.target.value);
      this.$emit("updatedDate", event.target.value);
      // this.calendarYear = event.target.value.split('-')[0];
    },
  },
  computed: {
    returnYear: function () {
      // console.warn(this.calendarYear.split('-')[0]);
      return this.calendarYear.split("-")[0];
    },
  },
};
</script>
