<template>
  <div>
    <!-- Vertical navbar -->
    <div class="vertical-nav bg-white" id="sidebar">
      <div class="py-4 px-3 mb-4 bg-light">
        <div class="media d-flex align-items-center">
          <img
            :src="brand"
            alt="..."
            width="65"
            class="mr-3 rounded-circle img-thumbnail shadow-sm"
          />
          <div class="media-body">
            <h4 class="m-0">{{ username || "Name Here" }}</h4>
            <p class="font-weight-light text-muted mb-0">Technologycredit.io</p>
          </div>
        </div>
      </div>

      <p class="text-gray font-weight-bold text-uppercase px-3 small mb-0">
        Main
      </p>

      <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item" @click="handleSelect(2)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 2 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-th-large mr-3 text-primary fa-fw"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item" @click="handleSelect(2.1)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 2.1 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-address-card mr-3 text-primary fa-fw"></i>
            Billing
          </a>
        </li>
        <li class="nav-item" @click="handleSelect(3)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 3 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-address-card mr-3 text-primary fa-fw"></i>
            Tracking Credits
          </a>
        </li>
        <li class="nav-item" @click="handleSelect(6)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 6 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-bar-chart mr-3 text-primary fa-fw"></i>
            Profile
          </a>
        </li>
        <li class="nav-item" @click="handleSelect(8)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 8 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-pie-chart mr-3 text-primary fa-fw"></i>
            Settings
          </a>
        </li>
      </ul>

      <p class="text-gray font-weight-bold text-uppercase px-3 small mb-0 mt-3">
        Forms
      </p>
      <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item" @click="handleSelect(4.1)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 4.1 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-th-large mr-3 text-primary fa-fw"></i>
            Forms Filed
          </a>
        </li>
        <li class="nav-item" @click="handleSelect(4.2)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 4.2 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-address-card mr-3 text-primary fa-fw"></i>
            Power of Attorney and Statement of Work
          </a>
        </li>
      </ul>

      <p class="text-gray font-weight-bold text-uppercase px-3 small mt-3 mb-0">
        Analyzer
      </p>
      <ul class="nav flex-column bg-white mb-0">
        <!-- <li class="nav-item" @click="handleSelect(9.1)">
          <a href="#" :class="['nav-link font-italic', (selectedNavItem === 9.1) ? 'text-white bg-primary' : 'text-dark']">
            <i class="fa fa-area-chart mr-3 text-primary fa-fw"></i>
            Qualifying Questions
          </a>
        </li>
        <li class="nav-item" @click="handleSelect(9.2)">
          <a href="#" :class="['nav-link font-italic', (selectedNavItem === 9.2) ? 'text-white bg-primary' : 'text-dark']">
            <i class="fa fa-bar-chart mr-3 text-primary fa-fw"></i>
            Financial Data
          </a>
        </li>
        <li class="nav-item" @click="handleSelect(9.3)">
          <a href="#" :class="['nav-link font-italic', (selectedNavItem === 9.3) ? 'text-white bg-primary' : 'text-dark']">
            <i class="fa fa-pie-chart mr-3 text-primary fa-fw"></i>
            Qualifying Percentages
          </a>
        </li>
        <li class="nav-item" @click="handleSelect(9.4)">
          <a href="#" :class="['nav-link font-italic', (selectedNavItem === 9.4) ? 'text-white bg-primary' : 'text-dark']">
            <i class="fa fa-pie-chart mr-3 text-primary fa-fw"></i>
            Project Documentation
          </a>
        </li>
        <li class="nav-item" @click="handleSelect(9.5)">
          <a href="#" :class="['nav-link font-italic', (selectedNavItem === 9.5) ? 'text-white bg-primary' : 'text-dark']">
            <i class="fa fa-pie-chart mr-3 text-primary fa-fw"></i>
            Reports
          </a>
        </li> -->
        <li class="nav-item" @click="handleSelect(5)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 5 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-area-chart mr-3 text-primary fa-fw"></i>
            Template Forms
          </a>
        </li>
      </ul>

      <p class="text-gray font-weight-bold text-uppercase px-3 small mt-3 mb-0">
        Sidebar
      </p>
      <ul class="nav flex-column bg-white mb-0">
        <!-- <li class="nav-item" @click="handleSelect(1)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 1 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-area-chart mr-3 text-primary fa-fw"></i>
            Users
          </a>
        </li> -->
        <li class="nav-item" @click="handleSelect(7)">
          <a
            href="#"
            :class="[
              'nav-link font-italic',
              selectedNavItem === 7 ? 'text-white bg-primary' : 'text-dark',
            ]"
          >
            <i class="fa fa-bar-chart mr-3 text-primary fa-fw"></i>
            Setup
          </a>
        </li>
      </ul>
    </div>
    <!-- End vertical navbar -->
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "DashboardSidebarMenuComponent",
  props: {
    brand: String,
    username: String,
  },
  data() {
    return {
      selectedNavItem: 0,
    };
  },
  computed: {
    ...mapGetters(["returnActiveUser"]),
  },
  methods: {
    ...mapActions(["setSelectedMenu"]),
    handleOpen(key, keyPath) {
      // console.log(key, keyPath);
    },
    handleClose() {},
    handleSelect(menuIndex) {
      this.selectedNavItem = menuIndex;
      this.setSelectedMenu(menuIndex);
      // console.log("handleSelect ", typeof menuIndex, "  ", menuIndex);
    },
    handleOpenAlt(key, keyPath) {
      // console.log(key, keyPath);
    },
    handleCloseAlt() {},
    handleSelectAlt(menuIndex) {
      this.setSelectedMenu(menuIndex);
      // console.log("handleSelect ", typeof menuIndex, "  ", menuIndex);
    },
  },
};
</script>

<style lang="scss" scoped>
#sidebar {
  overflow-y: scroll;
}
</style>
