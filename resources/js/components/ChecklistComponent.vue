<template>
  <div class="no-gutters bg-white p-4" style="height: 37rem; overflow: scroll">
    <h5 class="font-weight-bolder">Checklist <small>click row to complete and cross out</small></h5>
    <div class="row" v-for="(listItem, index) in this.returnCompanyChecklist" :key="index">
      <div
        class="col-9 bg-light p-3 mb-2 checklistItem" @click="toggleChecklistItem(listItem.id)">
        <s v-if="listItem.completed === 1" class="text-danger">{{ listItem.item }}</s>
        <b v-else>{{ listItem.item }}</b>
      </div>
      <div class="col-3 my-auto">
        <el-button class="d-block" type="danger" @click="deleteChecklistItem(listItem.id)">x</el-button>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "ChecklistComponent",
    computed: {
      ...mapGetters(['returnCompanyChecklist']),
    },
    methods: {
      ...mapActions(['updateCompanyChecklistItem', 'onDeleteChecklistID']),
      toggleChecklistItem(itemID) {
        this.updateCompanyChecklistItem(itemID); // -1 to account for checklist stored items starting at 0
      },
      deleteChecklistItem(checklistId) {
        this.onDeleteChecklistID(checklistId);
      }
    }
  }
</script>

<style lang="scss" scoped>
  .checklistItem{
    &:hover{
      cursor: pointer;
     }
  }

</style>
