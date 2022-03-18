<template>
  <div>
    <div id="capture">
      <div class="row">
        <div class="col-12">
          <canvas class="mx-auto" ref="canvas" id="myChart" height="400" width="400" :options="{ legend: { display: false }}"></canvas>
        </div>
        <div class="col-lg-4 col-12 text-center my-auto">
          <h6 class="font-weight-bold text-danger mt-4">Total Credits</h6>
          <h4 class="text-danger">{{ returnFormattedCompanyCreditsAvailable }}</h4>
        </div>
        <div class="col-lg-4 col-12 text-center my-auto">
          <h6 class="font-weight-bold text-primary mt-4">Credits Filed</h6>
          <h4 class="text-primary">{{ returnFormattedCompanyCreditsClaimed }}</h4>
        </div>
        <div class="col-lg-4 col-12 text-center my-auto">
          <h6 class="font-weight-bold text-success mt-4">Credits Received</h6>
          <h4 class="text-success">{{ returnFormattedCompanyCreditsReceived }}</h4>
        </div>
      </div>
    </div>


    <div>
      <el-button type="primary" class="mt-3" @click="capture">Download Report</el-button>
    </div>

  </div>
</template>

<script>
  import {PDFDocument, rgb, StandardFonts} from 'pdf-lib';
  import {Bar} from 'vue-chartjs'
  import htmlToImage from 'html-to-image';
  import download from "downloadjs";
  import moment from "moment";
  import axios from "axios";
  import {mapGetters} from "vuex";
  import NumberFormatter from "../../utilities/NumberFormatter";

  export default {
    extends: Bar,
    name: "CreditsChartComponent",
    data() {
      return {
        series: [{
          data: [400, 580, 1380]
        }],
        chartOptions: {
          chart: {
            type: 'bar'
          },
          plotOptions: {
            bar: {
              horizontal: true,
            }
          },
          colors: ['#F44336', '#E91E63', '#9C27B0'],
          dataLabels: {
            enabled: false
          },
          xaxis: {
            categories: ['South Korea', 'Canada', 'United Kingdom'],
          }
        }
      }
    },
    mounted() {
      this.renderBarChart()
    },
    beforeUpdate() {
      this.$data._chart.destroy();
      this.renderBarChart()
    },
    computed: {
      ...mapGetters(['returnTotalCompanyCreditsAvailable',
        'returnTotalCompanyCreditsClaimed',
        'returnTotalCompanyCreditsReceived',
        'returnTotalCompanyCreditsAmount',
        'returnCurrentActiveCompany',
        'returnStoredCompanyEvents']),
      returnFormattedCompanyCreditsAvailable() {
        return NumberFormatter.convertToStringAndAddDecimal(this.returnTotalCompanyCreditsAmount.toFixed(2))
      },
      returnFormattedCompanyCreditsClaimed() {
        return NumberFormatter.convertToStringAndAddDecimal(this.returnTotalCompanyCreditsClaimed.toFixed(2))
      },
      returnFormattedCompanyCreditsReceived() {
        return NumberFormatter.convertToStringAndAddDecimal(this.returnTotalCompanyCreditsReceived.toFixed(2))
      },
    },
    methods: {
      renderBarChart() {
        this.renderChart({
            labels: ['Total Credits', 'Credits Filed', 'Credits Recieved'],
            datasets: [{
              label: "",
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(75, 192, 192, 0.2)',
              ],
              borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
              ],
              borderWidth: 1,
              data: [this.returnTotalCompanyCreditsAmount.toFixed(2), this.returnTotalCompanyCreditsClaimed.toFixed(2), this.returnTotalCompanyCreditsReceived.toFixed(2), 0],
            }],
          },
          {
            legend: {
              display: false,
            },
            responsive: false,
            maintainAspectRatio: true,
            title: {
              display: true,
              text: `${(this.returnCurrentActiveCompany !== null) ? this.returnCurrentActiveCompany.name : ''}`
            }
          },
        )
      },
      capture() {
        const that = this;
        htmlToImage.toPng(document.getElementById('capture'))
        .then(async function (dataUrl) {

          const {data} = await axios.post('/api/company/b64-upload', {b64: dataUrl});

          // Returns Base64 encoded Image
          // Send to server to decode and store
          // Return URL
          // Generate report
          const pngUrl = data.image;
          const pngImageBytes = await fetch(pngUrl).then((res) => res.arrayBuffer());

          const pdfDoc = await PDFDocument.create();

          /* Embed */
          const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);
          const pngImage = await pdfDoc.embedPng(pngImageBytes);
          const pngDims = pngImage.scale(0.5);

          const page = pdfDoc.addPage();

          const COLOR = rgb(0, 0, 0);
          const baseOptions = {
            size: 10,
            font: helveticaFont,
            color: COLOR,
          };

          const baseOptionsHeading = {
            size: 11,
            font: helveticaFont,
            color: COLOR,
          };

          const baseOptionsTitle = {
            size: 15,
            font: helveticaFont,
            color: COLOR,
          };

          /* Draw Title*/
          page.drawText('Summary Report', {
            x: page.getWidth() / 2 - 75,
            y: page.getHeight() / 2 + 400,
            width: (pngDims.width) / 1.25,
            height: (pngDims.height) / 1.25,
            ...baseOptionsTitle
          });


          /* Draw Image */
          page.drawImage(pngImage, {
            // y: page.getHeight() / 2 - pngDims.height + 450,
            // y: page.getHeight() / 2 - 75,
            // x: page.getWidth() / 2 - 300,
            // y: page.getHeight() / 2 - 25,
            x: page.getWidth() / 2 - pngDims.width / 2 + 65,
            y: page.getHeight() / 2 - pngDims.height / 2 + 225,
            width: (pngDims.width) / 1.25,
            height: (pngDims.height) / 1.25,
          });

          page.drawRectangle({
            x: page.getWidth() / 2 - 275,
            // y: page.getHeight() / 2 - pngDims.height + 430,
            y: page.getHeight() / 2 - 65,
            width: 550,
            height: .5,
            color: rgb(0, 0, 0),
          });

          /* Draw Company Messages : Latest 5
          * Already orders from latest @ top
          * */
          const company_events = that.returnStoredCompanyEvents;
          // console.warn(company_events.length, company_events);

                    if (company_events.length > 0) {
                        let idx = 0;
                        company_events.forEach(el => {

                          if (idx < 5) {
                            // Date
                            page.drawText((moment(el.created_at).format('MM-DD-YYYY')).toString(), {
                              // x: page.getWidth() / 2 - pngDims.width / 2 + 100,
                              // y: page.getHeight() / 2 - 325 + (410 - (idx * 50)),
                              x: page.getWidth() / 2 - 275,
                              y: page.getHeight() / 2 - 85 - (idx * 50),
                              width: (pngDims.width) / 1.25,
                              height: (pngDims.height) / 1.25,
                              ...baseOptions
                            });

                            // Title
                            page.drawText(el.title, {
                              // x: page.getWidth() / 2 - pngDims.width / 2 + 100,
                              // y: page.getHeight() / 2 - pngDims.height + (400 - (idx * 50)),
                              x: page.getWidth() / 2 - 275,
                              y: page.getHeight() / 2 - 95 - (idx * 50),
                              width: (pngDims.width) / 1.25,
                              height: (pngDims.height) / 1.25,
                              ...baseOptions
                            });

                            // Body
                            page.drawText(el.body, {
                              // x: page.getWidth() / 2 - pngDims.width / 2 + 100,
                              // y: page.getHeight() / 2 - pngDims.height + (390 - (idx * 50)),
                              x: page.getWidth() / 2 - 275,
                              y: page.getHeight() / 2 - 105 - (idx * 50),
                              width: (pngDims.width) / 1.25,
                              height: (pngDims.height) / 1.25,
                              ...baseOptions
                            });

                            // Blank
                            page.drawRectangle({
                              // x: page.getWidth() / 2 - pngDims.width / 2 + 100,
                              // y: page.getHeight() / 2 - pngDims.height + (385 - (idx * 50)),
                              x: page.getWidth() / 2 - 275,
                              y: page.getHeight() / 2 - 115 - (idx * 50),
                              width: 250,
                              height: .01,
                              color: rgb(0, 0, 0),
                            });
                          } else return;

                          idx += 1;
                        })
                    }


          const pdfBytes = await pdfDoc.save();

          download(pdfBytes, `Summary Report` + '.pdf', "application/pdf");

          that.$notify({
            title: 'Success',
            message: 'Report successfully generated and downloaded.',
            type: 'success'
          });

        });

        // htmlToImage.toJpeg(document.getElementById('capture'), { backgroundColor: '#fffff', quality: 0.95, })
        // .then(function (dataUrl) {
        //   let link = document.createElement('a');
        //   link.download = 'my-image-name.jpeg';
        //   link.href = dataUrl;
        //   link.click();
        // });

      },
    }
  }
</script>
