<template>
  <div class="container-fluid">

    <div class="row">

      <div class="col-lg-6 col-12 ml-0 pl-0 mr-0 pr-0">
        <accounts-and-company-associated-component :env_type="env_type"/>
      </div>

      <div class="col-lg-6 col-12 mr-0 pr-0">
        <new-user-with-company-component/>
      </div>

    </div>
  </div>
</template>

<script>
    import AccountsAndCompanyAssociatedComponent from "./AccountsAndCompanyAssociatedComponent";
    import NewUserWithCompanyComponent from "./NewUserWithCompanyComponent";

    export default {
        name: "UserAccountsComponent",
        components: {NewUserWithCompanyComponent, AccountsAndCompanyAssociatedComponent},
        props: {
            env_type: String
        }
    }
</script>

<style scoped>

</style>
