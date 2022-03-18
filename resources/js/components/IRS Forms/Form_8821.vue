<template>
  <div class="container-fluid">
    <div class="row bg-white">
      <div class="col-12 p-4 mb-3">
        <h4 class="alert-info p-2 text-center">Form 8821</h4>
      </div>

      <div class="col-12">
        <h6 class="text-primary font-weight-bolder mt-2">
          Taxpayer Information
        </h6>
      </div>

      <div class="col-6">
        <div class="form-group">
          <label for="">Taxpayer identification number</label>
          <el-input
            type="text"
            name=""
            placeholder=""
            aria-describedby="helpId"
            v-model="taxIdentification.input"
            show-word-limit
            maxlength="25"
          />
          <small v-show="taxIdentification.error" class="text-danger"
            >Enter a Tax identification number</small
          >
        </div>

        <div class="form-group">
          <label for="">Name</label>
          <el-input
            type="text"
            name=""
            placeholder=""
            aria-describedby="helpId"
            v-model="name.input"
            show-word-limit
            maxlength="125"
          />
          <small v-show="name.error" class="text-danger"
            >Enter a Tax identification number</small
          >
        </div>

        <div class="form-group">
          <label for="">Address</label>
          <el-input
            type="text"
            name=""
            placeholder=""
            aria-describedby="helpId"
            v-model="address.input"
            show-word-limit
            maxlength="125"
          />
          <small v-show="address.error" class="text-danger"
            >Enter a Tax identification number</small
          >
        </div>

        <div class="form-group">
          <label for="">Year(s) or Period(s)</label>
          <el-input
            type="text"
            name=""
            placeholder=""
            aria-describedby="helpId"
            v-model="years.input"
            show-word-limit
            maxlength="125"
          />
          <small v-show="years.error" class="text-danger"
            >Enter a Tax identification number</small
          >
        </div>
      </div>

      <div class="col-6">
        <div class="form-group">
          <label for="">City</label>
          <el-input
            type="text"
            name=""
            placeholder=""
            aria-describedby="helpId"
            v-model="city.input"
            show-word-limit
            maxlength="125"
          />
          <small v-show="city.error" class="text-danger"
            >Enter a Tax identification number</small
          >
        </div>

        <div class="form-group">
          <label for="">State</label>
          <el-input
            type="text"
            name=""
            placeholder=""
            aria-describedby="helpId"
            v-model="state.input"
            show-word-limit
            maxlength="2"
            minlength="2"
          />
          <small v-show="state.error" class="text-danger"
            >Enter a Tax identification number</small
          >
        </div>

        <div class="form-group">
          <label for="">Zip</label>
          <el-input
            type="text"
            name=""
            placeholder=""
            aria-describedby="helpId"
            v-model="zip.input"
            show-word-limit
            maxlength="5"
            minlength="5"
          />
          <small v-show="zip.error" class="text-danger"
            >Enter a Tax identification number</small
          >
        </div>
      </div>

      <div class="col-12 mb-3">
        <el-button type="primary" @click="exportToPDF"
          >Generate 8821 PDF</el-button
        >
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { PDFDocument, rgb, StandardFonts } from "pdf-lib";
import download from "downloadjs";

export default {
  name: "Form_8821",
  props: {
    formUrl: String,
    disableDownload: String,
  },
  mounted() {
    // console.log('Form 8821 Props ', this.formUrl);
    if (this.returnCurrentActiveCompany) {
      this.name.input = this.returnCurrentActiveCompany.name;
    }
  },
  data() {
    return {
      taxIdentification: {
        input: "",
        error: false,
      },
      name: {
        input: "",
        error: false,
      },
      address: {
        input: "",
        error: false,
      },
      city: {
        input: "",
        error: false,
      },
      state: {
        input: "",
        error: false,
      },
      zip: {
        input: "",
        error: false,
      },
      years: {
        input: "",
        error: false,
      },
    };
  },
  methods: {
    validation() {
      let errCount = 0;

      if (this.taxIdentification.input.length < 1) {
        errCount++;
        this.taxIdentification.error = true;
      } else this.taxIdentification.error = false;

      if (this.name.input.length < 1) {
        errCount++;
        this.name.error = true;
      } else this.name.error = false;

      if (this.address.input.length < 1) {
        errCount++;
        this.address.error = true;
      } else this.address.error = false;

      if (this.years.input.length < 1) {
        errCount++;
        this.years.error = true;
      } else this.years.error = false;

      if (this.city.input.length < 1) {
        errCount++;
        this.city.error = true;
      } else this.city.error = false;

      if (this.state.input.length < 1) {
        errCount++;
        this.state.error = true;
      } else this.state.error = false;

      if (this.zip.input.length < 1) {
        errCount++;
        this.zip.error = true;
      } else this.zip.error = false;

      return errCount;
    },
    async exportToPDF() {
      const flag = this.validation();
      // console.log(flag);

      if (flag === 0) {
        const existingPdfBytes = await fetch(this.formUrl).then((res) =>
          res.arrayBuffer()
        );

        const pdfDoc = await PDFDocument.load(existingPdfBytes);
        const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);

        const pages = pdfDoc.getPages();
        const firstPage = pages[0];
        const { width, height } = firstPage.getSize();
        const COLOR = rgb(0, 0, 0);
        const baseOptions = {
          size: 8,
          font: helveticaFont,
          color: COLOR,
        };
        const baseYOffset = 23;

        firstPage.drawText(this.taxIdentification.input, {
          x: 350,
          y: height / 2 + 268,
          ...baseOptions,
        });

        firstPage.drawText(this.name.input, {
          x: 35,
          y: height / 2 + 265,
          ...baseOptions,
        });

        firstPage.drawText(this.address.input, {
          x: 35,
          y: height / 2 + 255,
          ...baseOptions,
        });

        firstPage.drawText(
          `${this.city.input}, ${this.state.input} ${this.zip.input}`,
          {
            x: 35,
            y: height / 2 + 245,
            ...baseOptions,
          }
        );

        /* Appointee */
        firstPage.drawText("Zhen Wang", {
          x: 35,
          y: height / 2 + 195,
          ...baseOptions,
        });

        firstPage.drawText("10424 E. Live Oak Ave ", {
          x: 35,
          y: height / 2 + 185,
          ...baseOptions,
        });

        firstPage.drawText("Arcadia, CA. 91007", {
          x: 35,
          y: height / 2 + 175,
          ...baseOptions,
        });

        /*CAF*/
        firstPage.drawText("0313-83186R", {
          x: 425,
          y: height / 2 + 208,
          ...baseOptions,
        });

        firstPage.drawText("323 377 3043", {
          x: 425,
          y: height / 2 + 183,
          ...baseOptions,
        });

        firstPage.drawText("Payroll", {
          x: 35,
          y: height / 2 + 55,
          ...baseOptions,
        });

        firstPage.drawText("941 and 941X", {
          x: 190,
          y: height / 2 + 55,
          ...baseOptions,
        });

        firstPage.drawText(this.years.input, {
          x: 320,
          y: height / 2 + 55,
          ...baseOptions,
        });

        firstPage.drawText("Payroll Refund Claim", {
          x: 450,
          y: height / 2 + 55,
          ...baseOptions,
        });

        this.$notify({
          title: "Success",
          message: "Downloading 8821 PDF.",
          type: "success",
        });

        /* Save report and Download*/
        const pdfBytes = await pdfDoc.save();
        // Trigger the browser to download the PDF document
        download(pdfBytes, `IRS-8821-${Date.now()}.pdf`, "application/pdf");
      } else {
        this.$notify({
          title: "Failed",
          message: "Please check for errors.",
          type: "error",
        });
      }
    },
  },
  computed: {
    ...mapGetters(["returnCurrentActiveCompany"]),
  },
};
</script>

<style scoped>
</style>
