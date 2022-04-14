<template>
  <section>
    <client-details-header-component />

    <user-accounts-component
      v-if="
        this.returnSelectedMenu === 1 && this.auth_object.status === 'Admin'
      "
      :env_type="this.environment_type"
      :auth="this.auth_object.status"
    />

    <!--Dashboard-->
    <dashboard-component
      v-if="
        (this.returnSelectedMenu === 2) &
        (this.returnCurrentActiveCompany !== null)
      "
    />

    <!--Billing-->
    <billing-component
      v-if="
        (this.returnSelectedMenu === 2.1) &
        (this.returnCurrentActiveCompany !== null)
      "
    />

    <!--Research and Development-->
    <research-and-development-credits-component
      v-if="
        this.returnSelectedMenu === 3 &&
        this.returnCurrentActiveCompany !== null
      "
    />

    <!--Forms-->
    <forms-component
      v-if="
        this.returnSelectedMenu === 4.1 &&
        this.returnCurrentActiveCompany !== null
      "
      :ty_8974="t_8974"
      :ty_941="t_941"
      :ty_941_url="t_941_url"
      :ty_941s_url="t_941s_url"
      :ty_941s="t_941s"
      :ty_941x_url="t_941x_url"
      :ty_941x="t_941x"
      :ty_941x2020_url="t_941x_url"
      :ty_941x2020="t_941x"
      :ty_6765="t_6765"
      :ty_6765_url="t_6765_url"
      :ty_3523="t_3523"
      :ty_3523_url="t_3523_url"
      :ty_8821="t_8821"
      :ty_8821_url="t_8821_url"
      :type_941_2020="t_941_2020"
      :type_941_2020_url="t_941_2020_url"
      :type_941_2022="t_941_2022"
      :type_941_2022_url="t_941_2022_url"
    />

    <p-o-wand-s-o-w-component
      v-if="
        this.returnSelectedMenu === 4.2 &&
        this.returnCurrentActiveCompany !== null
      "
    />

    <!--IRS Forms-->
    <select-form-template
      v-if="this.returnSelectedMenu === 5"
      :type_8974="t_8974"
      :type_941="t_941"
      :type_941_url="t_941_url"
      :type_941s_url="t_941s_url"
      :type_941s="t_941s"
      :type_941x_url="t_941x_url"
      :type_941x="t_941x"
      :type_941x2020="t_941x2020"
      :type_941x2020_url="t_941x2020_url"
      :type_941x2021="t_941x2021"
      :type_941x2021_url="t_941x2021_url"
      :type_6765="t_6765"
      :type_6765_url="t_6765_url"
      :type_3523="t_3523"
      :type_3523_url="t_3523_url"
      :type_8821="t_8821"
      :type_8821_url="t_8821_url"
      :type_941_2020="t_941_2020"
      :type_941_2020_url="t_941_2020_url"
      :type_941_2021="t_941_2021"
      :type_941_2021_url="t_941_2021_url"
      :type_941_2022="t_941_2022"
      :type_941_2022_url="t_941_2022_url"
    />

    <!--Profile-->
    <profile-company-component
      v-show="
        this.returnSelectedMenu === 6 &&
        this.returnCurrentActiveCompany !== null
      "
    />

    <!--Setup-->
    <setup-company-component v-if="this.returnSelectedMenu === 7" />

    <settings-component
      v-if="
        this.returnSelectedMenu === 8 &&
        this.returnCurrentActiveCompany !== null
      "
    />

    <section>
      <article v-if="this.returnCurrentActiveCompany !== null">
        <qualifying-questions-component
          v-if="this.returnSelectedMenu === 9.1"
        />

        <financial-data-component
          v-if="this.returnSelectedMenu === 9.2"
        ></financial-data-component>

        <qualifying-percentages-component
          v-if="this.returnSelectedMenu === 9.3"
        ></qualifying-percentages-component>

        <project-documentation-component
          v-if="this.returnSelectedMenu === 9.4"
        ></project-documentation-component>
      </article>

      <!--      <article>-->
      <!--        <project-documentation-component v-if="this.returnSelectedMenu === 9.4"></project-documentation-component>-->
      <!--      </article>-->

      <article v-if="this.returnCurrentActiveCompany === null">
        <select-a-company-warning-component
          class="mt-3"
        ></select-a-company-warning-component>
      </article>
    </section>
  </section>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

import FinancialDataComponent from "./analyzer/FinancialDataComponent";
import SetupCompanyComponent from "./SetupCompanyComponent";
import ProfileCompanyComponent from "./ProfileCompanyComponent";
import DashboardComponent from "./DashboardComponent";
import ClientDetailsHeaderComponent from "./ClientDetailsHeaderComponent";
import ResearchAndDevelopmentCreditsComponent from "./ResearchAndDevelopmentCreditsComponent";
import FormsComponent from "./FormsComponent";
import SelectFormTemplate from "./SelectFormTemplate";
import POWandSOWComponent from "./POWandSOWComponent";
import OverviewComponent from "./OverviewComponent";
import Form_8821 from "./IRS Forms/Form_8821";
import UserAccountsComponent from "./UserAccountsComponent";
import SettingsComponent from "./SettingsComponent";
import Form_941_2020_Component from "./IRS Forms/Form_941_2020_Component";
import Form_941_2021_Component from "./IRS Forms/Form_941_2021_Component.vue";
import QualifyingQuestionsComponent from "./analyzer/QualifyingQuestionsComponent";
import BillingComponent from "./BillingComponent";
import QualifyingPercentagesComponent from "./analyzer/QualifyingPercentagesComponent";
import ProjectDocumentationComponent from "./analyzer/ProjectDocumentationComponent";
import SelectACompanyWarningComponent from "./warnings/SelectACompanyWarningComponent";

export default {
  name: "ApplicationContainer",
  props: {
    t_8974: String,
    t_941: String,
    t_941_url: String,
    t_941s_url: String,
    t_941s: String,
    t_941x_url: String,
    t_941x: String,
    t_941x2020: String,
    t_941x2020_url: String,
    t_941x2021: String,
    t_941x2021_url: String,
    t_6765: String,
    t_6765_url: String,
    t_3523: String,
    t_3523_url: String,
    t_8821: String,
    t_8821_url: String,
    t_941_2020: String,
    t_941_2020_url: String,
    t_941_2021: String,
    t_941_2021_url: String,
    t_941_2022: String,
    t_941_2022_url: String,
    auth_object: Object,
    environment_type: String,
  },
  data() {
    return {
      exclude: [],
    };
  },
  components: {
    FinancialDataComponent,
    QualifyingQuestionsComponent,
    ProjectDocumentationComponent,
    QualifyingPercentagesComponent,
    SelectACompanyWarningComponent,
    Form_941_2020_Component,
    Form_941_2021_Component,
    SettingsComponent,
    UserAccountsComponent,
    Form_8821,
    OverviewComponent,
    POWandSOWComponent,
    SelectFormTemplate,
    FormsComponent,
    ResearchAndDevelopmentCreditsComponent,
    ClientDetailsHeaderComponent,
    DashboardComponent,
    ProfileCompanyComponent,
    SetupCompanyComponent,
    BillingComponent,
  },
  computed: {
    ...mapGetters(["returnSelectedMenu", "returnCurrentActiveCompany"]),
  },
  methods: {
    ...mapActions(["setActiveUser"]),
  },
  mounted() {
    this.setActiveUser(this.auth_object);
  },
};
</script>
