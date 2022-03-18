<template>
  <div class="container-fluid">

    <div class="row bg-white p-4">
      <div class="col-12">
        <h5>Project Documentation</h5>
      </div>
      <div class="col-12" v-if="this.returnAnalyzerYearEnds.length > 0">
        <el-tabs v-model="activeName" @tab-click="handleClick" type="border-card">
          <el-tab-pane
            v-for="(item, index) in this.returnAnalyzerYearEnds"
            :key="index"
            :label="item.year"
            :name="index.toString()"
          >

            <h6 class="text-primary mb-3">{{ activeTabYear }}</h6>

            <el-tabs v-model="activeProject" @tab-click="handleClickProject" type="border-card">
              <el-tab-pane
                v-for="(project, index) in projectsArr"
                :key="index"
                :label="project.name"
                :name="index.toString()"
              >
                <!-- Questions -->
                <div class="row bg-white p-4">

                  <div class="col-12">
                    <el-steps :active="active" finish-status="success">
                      <el-step title="Step 1"></el-step>
                      <el-step title="Step 2"></el-step>
                      <el-step title="Step 3"></el-step>
                      <el-step title="Step 4"></el-step>
                      <el-step title="Step 5"></el-step>
                      <el-step title="Finalizes"></el-step>
                    </el-steps>

                    <div class="text-right mb-4">
                      <h2>Allow Next: {{ allowNext }}</h2>
                      <h2>Active Step: {{ active }}</h2>
                      <h2>Active Radio {{ step_1.radio }}</h2>
                      <el-button class="mt-3" type="secondary" size="mini" @click="previous">Previous step</el-button>
                      <el-button v-if="showNextBasedOnStep" class="mt-3" type="primary" size="mini" @click="next">Next step</el-button>
                    </div>
                    <hr>
                  </div>

                  <!-- Step 1 -->
                  <div class="col-12 mt-3" v-if="active === 0">
                    <h6 class="font-weight-bold">The project undertaken by the team is</h6>
                    <div>
                      <el-radio v-model="step_1.radio" label="1">New Development</el-radio>
                      <el-radio v-model="step_1.radio" label="2">Improvement</el-radio>
                      <el-radio v-model="step_1.radio" label="3">Both</el-radio>
                    </div>
                  </div>

                  <!-- Step 2 -->
                  <div class="col-12 mt-4" v-if="active === 1">
                    <h6 class="font-weight-bold">The project team consists of members with technical skillsets including</h6>
                    <div>
                      <el-checkbox-group
                        v-model="step_2.skills">
                        <el-checkbox v-for="skill in step_2.skillsetOptions" :label="skill" :key="skill" class="d-block">{{skill}}</el-checkbox>
                      </el-checkbox-group>
                    </div>
                  </div>

                  <!-- Step 3 -->
                  <div class="col-12 mt-4" v-if="active === 2">
                    <h6 class="font-weight-bold">Select the following activities that best match the nature of your development activities </h6>
                    <p>{{ step_3.activities }}</p>
                    <el-checkbox-group
                      v-model="step_3.activities">
                      <el-checkbox v-for="activity in step_3.activitiesOptions" :label="activity" :key="activity" class="d-block">{{activity}}</el-checkbox>
                    </el-checkbox-group>

                    <section>

                      <!-- IF Software Development Selected -->
                      <article v-if="optionWasSelection('Software Development')">
                        <hr>
                        <div class="bg-light">
                          <h6 class="p-2">Software Development</h6>
                        </div>

                        <el-checkbox-group
                          v-model="step_3.softwareDevelopmentChecked.checkedOptions">
                          <el-checkbox v-for="option in step_3.softwareDevelopmentChecked.options" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                        </el-checkbox-group>

                        <!-- New Development Selected -->
                        <div v-if="step_3.softwareDevelopmentChecked.checkedOptions.length > 0 && step_1.radio === '1'">
                          <div v-for="question in step_3.softwareDevelopmentChecked.newDevelopmentQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Improvement Selected -->
                        <div v-if="step_3.softwareDevelopmentChecked.checkedOptions.length > 0 && step_1.radio === '2'">
                          <div v-for="question in step_3.softwareDevelopmentChecked.improvementQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Both -->
                        <div v-if="step_3.softwareDevelopmentChecked.checkedOptions.length > 0 && step_1.radio === '3'">
                          <div v-for="question in step_3.softwareDevelopmentChecked.bothQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Other -->
                        <div v-if="step_3.softwareDevelopmentChecked.checkedOptions.length > 0 && step_3.softwareDevelopmentChecked.checkedOptions.includes('Other')">
                          <div v-for="question in step_3.softwareDevelopmentChecked.otherQuestion" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                      </article>

                      <!-- IF Firmware Developent Selected -->
                      <article v-if="optionWasSelection('Firmware Development')">
                        <hr>
                        <div class="bg-light">
                          <h6 class="p-2">Firmware Development</h6>
                        </div>

                        <el-checkbox-group
                          v-model="step_3.firmwareDevelopmentChecked.checkedOptions">
                          <el-checkbox v-for="option in step_3.firmwareDevelopmentChecked.options" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                        </el-checkbox-group>

                        <!-- New Development Selected -->
                        <div v-if="step_3.firmwareDevelopmentChecked.checkedOptions.length > 0 && step_1.radio === '1'">
                          <div v-for="question in step_3.firmwareDevelopmentChecked.newDevelopmentQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Improvement Selected -->
                        <div v-if="step_3.firmwareDevelopmentChecked.checkedOptions.length > 0 && step_1.radio === '2'">
                          <div v-for="question in step_3.firmwareDevelopmentChecked.improvementQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Both -->
                        <div v-if="step_3.firmwareDevelopmentChecked.checkedOptions.length > 0 && step_1.radio === '3'">
                          <div v-for="question in step_3.firmwareDevelopmentChecked.bothQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Other -->
                        <div v-if="step_3.firmwareDevelopmentChecked.checkedOptions.length > 0 && step_3.firmwareDevelopmentChecked.checkedOptions.includes('Other')">
                          <div v-for="question in step_3.firmwareDevelopmentChecked.otherQuestion" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                      </article>

                      <!-- IF Hardware Developent Selected -->
                      <article v-if="optionWasSelection('Hardware Development')">
                        <hr>
                        <div class="bg-light">
                          <h6 class="p-2">Hardware Development</h6>
                        </div>

                        <el-checkbox-group
                          v-model="step_3.hardwareDevelopmentChecked.checkedOptions">
                          <el-checkbox v-for="option in step_3.hardwareDevelopmentChecked.options" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                        </el-checkbox-group>

                        <!-- New Development Selected -->
                        <div v-if="step_3.hardwareDevelopmentChecked.checkedOptions.length > 0 && step_1.radio === '1'">
                          <div v-for="question in step_3.hardwareDevelopmentChecked.newDevelopmentQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Improvement Selected -->
                        <div v-if="step_3.hardwareDevelopmentChecked.checkedOptions.length > 0 && step_1.radio === '2'">
                          <div v-for="question in step_3.hardwareDevelopmentChecked.improvementQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Both -->
                        <div v-if="step_3.hardwareDevelopmentChecked.checkedOptions.length > 0 && step_1.radio === '3'">
                          <div v-for="question in step_3.hardwareDevelopmentChecked.bothQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Other -->
                        <div v-if="step_3.hardwareDevelopmentChecked.checkedOptions.length > 0 && step_3.hardwareDevelopmentChecked.checkedOptions.includes('Other')">
                          <div v-for="question in step_3.hardwareDevelopmentChecked.otherQuestion" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                      </article>

                      <!-- IF Bio Technology Product or Process Selected -->
                      <article v-if="optionWasSelection('Bio Technology Product or Process')">
                        <hr>
                        <div class="bg-light">
                          <h6 class="p-2">Bio Technology Product or Process</h6>
                        </div>

                        <el-checkbox-group
                          v-model="step_3.bioTechnologyProductOrProcessChecked.checkedOptions">
                          <el-checkbox v-for="option in step_3.bioTechnologyProductOrProcessChecked.options" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                        </el-checkbox-group>

                        <!-- New Development Selected -->
                        <div v-if="step_3.bioTechnologyProductOrProcessChecked.checkedOptions.length > 0 && step_1.radio === '1'">
                          <div v-for="question in step_3.bioTechnologyProductOrProcessChecked.newDevelopmentQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Improvement Selected -->
                        <div v-if="step_3.bioTechnologyProductOrProcessChecked.checkedOptions.length > 0 && step_1.radio === '2'">
                          <div v-for="question in step_3.bioTechnologyProductOrProcessChecked.improvementQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Both -->
                        <div v-if="step_3.bioTechnologyProductOrProcessChecked.checkedOptions.length > 0 && step_1.radio === '3'">
                          <div v-for="question in step_3.bioTechnologyProductOrProcessChecked.bothQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Other -->
                        <div v-if="step_3.bioTechnologyProductOrProcessChecked.checkedOptions.length > 0 && step_3.bioTechnologyProductOrProcessChecked.checkedOptions.includes('Other')">
                          <div v-for="question in step_3.bioTechnologyProductOrProcessChecked.otherQuestion" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                      </article>

                      <!-- IF Manufacturing Process Selected -->
                      <article v-if="optionWasSelection('Manufacturing Process')">
                        <hr>
                        <div class="bg-light">
                          <h6 class="p-2">Manufacturing Process</h6>
                        </div>

                        <el-checkbox-group
                          v-model="step_3.manufacturingProcessChecked.checkedOptions">
                          <el-checkbox v-for="option in step_3.manufacturingProcessChecked.options" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                        </el-checkbox-group>

                        <!-- New Development Selected -->
                        <div v-if="step_3.manufacturingProcessChecked.checkedOptions.length > 0 && step_1.radio === '1'">
                          <div v-for="question in step_3.manufacturingProcessChecked.newDevelopmentQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Improvement Selected -->
                        <div v-if="step_3.manufacturingProcessChecked.checkedOptions.length > 0 && step_1.radio === '2'">
                          <div v-for="question in step_3.manufacturingProcessChecked.improvementQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Both -->
                        <div v-if="step_3.manufacturingProcessChecked.checkedOptions.length > 0 && step_1.radio === '3'">
                          <div v-for="question in step_3.manufacturingProcessChecked.bothQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Other -->
                        <div v-if="step_3.manufacturingProcessChecked.checkedOptions.length > 0 && step_3.manufacturingProcessChecked.checkedOptions.includes('Other')">
                          <div v-for="question in step_3.manufacturingProcessChecked.otherQuestion" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                      </article>

                      <!-- IF Manufacturing Process Selected -->
                      <article v-if="optionWasSelection('Other')">
                        <hr>
                        <div class="bg-light">
                          <h6 class="p-2">Other</h6>
                        </div>

                        <el-checkbox-group
                          v-model="step_3.otherProcessChecked.checkedOptions">
                          <el-checkbox v-for="option in step_3.otherProcessChecked.options" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                        </el-checkbox-group>

                        <!-- New Development Selected -->
                        <div v-if="step_3.otherProcessChecked.checkedOptions.length > 0 && step_1.radio === '1'">
                          <div v-for="question in step_3.otherProcessChecked.newDevelopmentQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Improvement Selected -->
                        <div v-if="step_3.otherProcessChecked.checkedOptions.length > 0 && step_1.radio === '2'">
                          <div v-for="question in step_3.otherProcessChecked.improvementQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Both -->
                        <div v-if="step_3.otherProcessChecked.checkedOptions.length > 0 && step_1.radio === '3'">
                          <div v-for="question in step_3.otherProcessChecked.bothQuestions" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                        <!-- Other -->
                        <div v-if="step_3.otherProcessChecked.checkedOptions.length > 0 && step_3.otherProcessChecked.checkedOptions.includes('Other')">
                          <div v-for="question in step_3.otherProcessChecked.otherQuestion" :key="question.q">
                            <h6 class="mt-2">{{ question.q }}</h6>
                            <el-input
                              type="textarea"
                              :rows="3"
                              placeholder="Please input"
                              v-model="question.v">
                            </el-input>
                          </div>
                        </div>

                      </article>

                    </section>


                  </div>

                  <!-- Step 4 -->
                  <div class="col-12 mt-4" v-if="active === 3">
                    <h6 class="font-weight-bold">Files</h6>
                    <p>Select any of the internal documents you can upload to support your development activities</p>
                    <table class="table">
                      <thead>
                      <tr>
                        <th>Description</th>
                        <th>Upload</th>
                        <th>Options</th>
                      </tr>
                      </thead>
                      <tbody>

                      <!--#1-->
                      <tr>
                        <td scope="row">Pitch Deck describing your product if early stage company</td>
                        <td>
                          <a v-show="step_4.f1" class="mb-3" :href="step_4.f1">view file link</a>
                          <br><br>
                          <el-upload
                            class="upload-demo"
                            drag
                            action="api/company/analyzer/pd"
                            name="file_upload_one"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-change="handleChange"
                            :on-success="handleSuccess">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
                          </el-upload>
                        </td>
                        <td>delete</td>
                      </tr>

                      <!--#2-->
                      <tr>
                        <td scope="row">Product or Project Manual</td>
                        <td>
                          <a v-show="step_4.f2" class="mb-3" :href="step_4.f2">view file link</a>
                          <br><br>
                          <el-upload
                            class="upload-demo"
                            drag
                            action="api/company/analyzer/pd"
                            name="file_upload_two"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-change="handleChange"
                            :on-success="handleSuccess">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
                          </el-upload>
                        </td>
                        <td>delete</td>
                      </tr>

                      <!--#3-->
                      <tr>
                        <td scope="row">Project Plans (Specs, Drawings, or Presentations)</td>
                        <td>
                          <a v-show="step_4.f3" class="mb-3" :href="step_4.f3">view file link</a>
                          <br><br>
                          <el-upload
                            class="upload-demo"
                            drag
                            action="api/company/analyzer/pd"
                            name="file_upload_three"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-change="handleChange"
                            :on-success="handleSuccess">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
                          </el-upload>
                        </td>
                        <td>delete</td>
                      </tr>

                      <!--#4-->
                      <tr>
                        <td scope="row">Email describing the performance functionalies</td>
                        <td>
                          <a v-show="step_4.f4" class="mb-3" :href="step_4.f4">view file link</a>
                          <br><br>
                          <el-upload
                            class="upload-demo"
                            drag
                            action="api/company/analyzer/pd"
                            name="file_upload_four"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-change="handleChange"
                            :on-success="handleSuccess">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
                          </el-upload>
                        </td>
                        <td>delete</td>
                      </tr>

                      <!--#5-->
                      <tr>
                        <td scope="row">Project planning documents and budget approval</td>
                        <td>
                          <a v-show="step_4.f5" class="mb-3" :href="step_4.f5">view file link</a>
                          <br><br>
                          <el-upload
                            class="upload-demo"
                            drag
                            action="api/company/analyzer/pd"
                            name="file_upload_five"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-change="handleChange"
                            :on-success="handleSuccess">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
                          </el-upload>
                        </td>
                        <td>delete</td>
                      </tr>

                      <!--#6-->
                      <tr>
                        <td scope="row">Project Milestone and road map document</td>
                        <td>
                          <a v-show="step_4.f6" class="mb-3" :href="step_4.f6">view file link</a>
                          <br><br>
                          <el-upload
                            class="upload-demo"
                            drag
                            action="api/company/analyzer/pd"
                            name="file_upload_six"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-change="handleChange"
                            :on-success="handleSuccess">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
                          </el-upload>
                        </td>
                        <td>delete</td>
                      </tr>

                      <!--#7-->
                      <tr>
                        <td scope="row">Article, journal, or papers published for your unique development</td>
                        <td>
                          <a v-show="step_4.f7" class="mb-3" :href="step_4.f7">view file link</a>
                          <br><br>
                          <el-upload
                            class="upload-demo"
                            drag
                            action="api/company/analyzer/pd"
                            name="file_upload_seven"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-change="handleChange"
                            :on-success="handleSuccess">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
                          </el-upload>
                        </td>
                        <td>delete</td>
                      </tr>

                      </tbody>
                    </table>
                  </div>

                  <!-- Step 5 -->
                  <div class="col-12 mt-4" v-if="active === 4">
                    <h6 class="font-weight-bold">Project Technical Challenges</h6>
                    <p>Select the most relevant choice of the Uncertainties related to your project</p>

                    {{ step_5.checkedOptions }}

                    <el-checkbox-group
                      v-model="step_5.checkedOptions">
                      <el-checkbox v-for="option in step_5.options" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                    </el-checkbox-group>

                    <!-- Options with Additional Items -->
                    <section>
                      <article v-if="optionWasSelectionProjectTechnical('R&D Capability -- you or your team was uncertain if you would achieve your research or development objectives')">
                        <hr>
                        <h6 class="text-primary">R&D Capability</h6>
                        <p>{{ step_5.rdCapabilitiesChecked.objectives }}</p>

                        <el-checkbox-group
                          v-model="step_5.rdCapabilitiesChecked.objectives">
                          <el-checkbox v-for="option in step_5.rdCapabilitiesChecked.objectivesOptions" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                        </el-checkbox-group>

                        <h6 class="mt-2">{{ step_5.rdCapabilitiesChecked.capabilitiesQuestion.q }}</h6>
                        <el-input
                          type="textarea"
                          :rows="3"
                          placeholder="Please input"
                          v-model="step_5.rdCapabilitiesChecked.capabilitiesQuestion.v">
                        </el-input>

                        <div v-if="step_5.rdCapabilitiesChecked.objectives.includes('Other')">
                          <h6 class="mt-2">{{ step_5.rdCapabilitiesChecked.otherQuestion.q }}</h6>
                          <el-input
                            type="textarea"
                            :rows="3"
                            placeholder="Please input"
                            v-model="step_5.rdCapabilitiesChecked.otherQuestion.v">
                          </el-input>
                        </div>

                      </article>

                      <article v-if="optionWasSelectionProjectTechnical('R&D Methodology -- you or your team was unsure what method of development might be most technically feasible, reliable , and/or cost effective to achieve the desired outcome')">
                        <hr>
                        <h6 class="text-primary">R&D Methodology</h6>
                        <p>{{ step_5.rdMethodologiesChecked.objectives }}</p>

                        <el-checkbox-group
                          v-model="step_5.rdMethodologiesChecked.objectives">
                          <el-checkbox v-for="option in step_5.rdMethodologiesChecked.objectivesOptions" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                        </el-checkbox-group>

                        <h6 class="mt-2">{{ step_5.rdMethodologiesChecked.methodsQuestion.q }}</h6>
                        <el-input
                          type="textarea"
                          :rows="3"
                          placeholder="Please input"
                          v-model="step_5.rdMethodologiesChecked.methodsQuestion.v">
                        </el-input>

                        <div v-if="step_5.rdMethodologiesChecked.objectives.includes('Other')">
                          <h6 class="mt-2">{{ step_5.rdMethodologiesChecked.otherQuestion.q }}</h6>
                          <el-input
                            type="textarea"
                            :rows="3"
                            placeholder="Please input"
                            v-model="step_5.rdMethodologiesChecked.otherQuestion.v">
                          </el-input>
                        </div>
                      </article>

                      <article v-if="optionWasSelectionProjectTechnical('Appropriateness of Design -- you or your team was unsure what would be the most appropriate engineering design to achieve the technical capabilities of the product or process')">
                        <hr>
                        <h6 class="text-primary">Appropriateness of Design</h6>
                        <p>{{ step_5.appropriatenessChecked.objectives }}</p>

                        <el-checkbox-group
                          v-model="step_5.appropriatenessChecked.objectives">
                          <el-checkbox v-for="option in step_5.appropriatenessChecked.objectivesOptions" :label="option" :key="option" class="d-block">{{option}}</el-checkbox>
                        </el-checkbox-group>

                        <h6 class="mt-2">{{ step_5.appropriatenessChecked.designQuestion.q }}</h6>
                        <el-input
                          type="textarea"
                          :rows="3"
                          placeholder="Please input"
                          v-model="step_5.appropriatenessChecked.designQuestion.v">
                        </el-input>

                        <div v-if="step_5.appropriatenessChecked.objectives.includes('Other')">
                          <h6 class="mt-2">{{ step_5.appropriatenessChecked.otherQuestion.q }}</h6>
                          <el-input
                            type="textarea"
                            :rows="3"
                            placeholder="Please input"
                            v-model="step_5.appropriatenessChecked.otherQuestion.v">
                          </el-input>
                        </div>
                      </article>

                      <article class="mt-3">
                        <hr>
                        <h6 class="mt-2 font-weight-bold">{{ step_5.technicalChallengeQuestion.q }}</h6>
                        <el-input
                          type="textarea"
                          :rows="3"
                          placeholder="Please input"
                          v-model="step_5.technicalChallengeQuestion.v">
                        </el-input>
                      </article>
                    </section>



                  </div>

                  <!-- Step Finishing -->
                  <div class="col-12 mt-4" v-if="active === 5">
                    <h6 class="font-weight-bold">Finishing</h6>
                    <p>Please take time to</p>
                    <ul>
                      <li>
                        Review correct options were selected
                      </li>
                      <li>
                        All file content was attached
                      </li>
                      <li>
                        No errors
                      </li>
                    </ul>

                    <p class="bg-primary p-2 text-white">Click next to finalize and save</p>

                  </div>

                </div>
                <!-- Questions-END -->
              </el-tab-pane>
            </el-tabs>


          </el-tab-pane>
        </el-tabs>

        <hr/>
      </div>

      <div class="col-12" v-else>
        Please Select one Year from the available tabs and Enter at least one record in Financial Data to continue.
      </div>
    </div>


  </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import axios from "axios";

    export default {
        data() {
            return {
                active: 0,
                activeName: "first",
                activeProject: "",
                activeTabYear: "",
                activeTanProject: "",
                projectsArr: [],
                projectsRecord: "",
                allowNext: true,
                // Step 1
                step_1: {
                    radio: '1'
                },
                // Step 2
                step_2: {
                    skillsetOptions: ['Software Engineering', 'Data Modeling', 'System Engineering', 'Technician', 'Scientific Researching', 'Chemistry', 'Biology', 'Mechanical Engineering', 'Product Managing'],
                    skills: []
                },
                step_3: {
                    activitiesOptions: ['Software Development', 'Firmware Development', 'Hardware Development', 'Bio Technology Product or Process', 'Manufacturing Process', 'Other'],
                    activities: [],
                    softwareDevelopmentChecked: {
                        options: ['Architecture Design and Development', 'Database Design and Development', 'Front End Design and Development', 'Back End Design and Development', 'Other'],
                        checkedOptions: [],
                        newDevelopmentQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        improvementQuestions: {
                            1: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            2: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        bothQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            },
                            4: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            5: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            }
                        },
                        otherQuestion: {
                            1: {
                                q: 'Please specify other',
                                v: ''
                            }
                        }
                    },
                    firmwareDevelopmentChecked: {
                        options: ['Architecture Design and Development', 'Database Design and Development', 'Front End Design and Development', 'Back End Design and Development', 'Other'],
                        checkedOptions: [],
                        newDevelopmentQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        improvementQuestions: {
                            1: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            2: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        bothQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            },
                            4: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            5: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            }
                        },
                        otherQuestion: {
                            1: {
                                q: 'Please specify other',
                                v: ''
                            }
                        }
                    },
                    hardwareDevelopmentChecked: {
                        options: ['Foam Factor Design and Development', 'Functionality Design and Development', 'Design for manufacturability', 'Pilot Manufacturing', 'Yield Improvement', 'Other'],
                        checkedOptions: [],
                        newDevelopmentQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        improvementQuestions: {
                            1: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            2: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        bothQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            },
                            4: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            5: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            }
                        },
                        otherQuestion: {
                            1: {
                                q: 'Please specify other',
                                v: ''
                            }
                        }
                    },
                    bioTechnologyProductOrProcessChecked: {
                        options: ['New Drug Discovery', 'Active Pharmatheutical Ingredient Development', 'Design for manufacturability', 'Cleanroom/Lab design and building', 'Phase I/II/III clinical design and development', 'Other'],
                        checkedOptions: [],
                        newDevelopmentQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        improvementQuestions: {
                            1: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            2: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        bothQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            },
                            4: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            5: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            }
                        },
                        otherQuestion: {
                            1: {
                                q: 'Please specify other',
                                v: ''
                            }
                        }
                    },
                    manufacturingProcessChecked: {
                        options: ['Pilot manufacturing', 'Yield improvement', 'Other'],
                        checkedOptions: [],
                        newDevelopmentQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        improvementQuestions: {
                            1: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            2: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        bothQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            },
                            4: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            5: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            }
                        },
                        otherQuestion: {
                            1: {
                                q: 'Please specify other',
                                v: ''
                            }
                        }
                    },
                    otherProcessChecked: {
                        options: ['Other'],
                        checkedOptions: [],
                        newDevelopmentQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        improvementQuestions: {
                            1: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            2: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            }
                        },
                        bothQuestions: {
                            1: {
                                q: 'List all of the functionality or performance goals under this development',
                                v: ''
                            },
                            2: {
                                q: 'List all of the reliability and quality goals under this development',
                                v: ''
                            },
                            3: {
                                q: 'List all of the technology enablement that would achieve cost reduction goals',
                                v: ''
                            },
                            4: {
                                q: 'What kind of Functionalities or Performances were Improved',
                                v: ''
                            },
                            5: {
                                q: 'What kind of Reliability or Quality were Improved',
                                v: ''
                            }
                        },
                        otherQuestion: {
                            1: {
                                q: 'Please specify other',
                                v: ''
                            }
                        }
                    }
                },
                step_4: {
                    f1: "",
                    f2: "",
                    f3: "",
                    f4: "",
                    f5: "",
                    f6: "",
                    f7: "",
                },
                step_5: {
                  options: ["R&D Capability -- you or your team was uncertain if you would achieve your research or development objectives",
                  "R&D Methodology -- you or your team was unsure what method of development might be most technically feasible, reliable , and/or cost effective to achieve the desired outcome",
                  "Appropriateness of Design -- you or your team was unsure what would be the most appropriate engineering design to achieve the technical capabilities of the product or process"],
                  checkedOptions: [],
                  rdCapabilitiesChecked: {
                      objectivesOptions: ["Lack of sufficient knowledge about the outcome of the product", "Lack of general industry know-how of the subject matter", "Limitation of the current team member(s)' technical knowledge", "The subject matter in research or development is highly technical that there is no readily available product or process that mimic what we are doing", "Other"],
                      objectives: [],
                      capabilitiesQuestion: {
                          q: 'What were the capabilities desired?',
                          v: ''
                      },
                      otherQuestion: {
                          q: 'Please specify other',
                          v: ''
                      }
                  },
                  rdMethodologiesChecked: {
                        objectivesOptions: [
                            "Unsure of the most robust software architecture",
                            "Unsure of the most reliable backend coding and algorithms design to achieve above objectives",
                            "Unsure if the data can be manipulated to generate unique format for processing",
                            "Unsure if the software platform can achieve the scale based on existing software design component",
                            "Other"
                        ],
                        objectives: [],
                        methodsQuestion: {
                            q: 'Describe the method(s) you were unsure of',
                            v: ''
                        },
                        otherQuestion: {
                            q: 'Please specify other',
                            v: ''
                        }
                },
                  appropriatenessChecked: {
                        objectivesOptions: [
                            "Unsure of the most robust software architecture",
                            "Unsure of the most reliable backend coding and algorithms design to achieve above objectives",
                            "Unsure if the data can be manipulated to generate unique format for processing",
                            "Unsure if the software platform can achieve the scale based on existing software design component",
                            "Other"
                        ],
                        objectives: [],
                        designQuestion: {
                            q: 'What design(s) were considered',
                            v: ''
                        },
                        otherQuestion: {
                            q: 'Please specify other',
                            v: ''
                        }
                    },
                  technicalChallengeQuestion: {
                      q: 'Please provide a brief description of technical challenges ',
                      v: ''
                  }
                }
            };
        },
        computed: {
            ...mapGetters([
                "returnAnalyzerYearEnds",
                "returnCheckForQalifyingQuestionsClaimYears",
                "returnActiveTabYearId"
            ]),
            showNextBasedOnStep() {
                switch (this.active) {
                    case 1:
                        return (this.step_2.skills.length === 0) ? this.allowNext = false : this.allowNext = true;
                        break;
                    case 2:
                        return (this.step_3.activities.length === 0) ? this.allowNext = false : this.allowNext = true;
                        break;
                    default:
                        return true;
                        break;
                }
            }
        },
        methods: {
            ...mapActions([
                "setNewFinancialDataEntryYear",
            ]),
            async returnProjectData(){
                if (this.returnActiveTabYearId) {
                    const {data, status} = await axios.get(`api/company/analyzer/qp/${this.returnActiveTabYearId}`);
                    // console.warn('Project Documentation : Created | Getting Project Array Data! ', data[0]);
                    // Assign Record
                    this.projectsRecord = data[0];
                    if (this.projectsRecord !== undefined) {
                        this.projectsArr = JSON.parse(data[0].projects) || [];
                    } else {
                        this.projectsArr = [];
                    }
                } else {
                    // console.error('Created : QualifyingPercentageComponent QQID returned NULL');
                    this.projectsRecord === null;
                }
            },
            handleClick(tab, event) {
                this.activeTabYear = event.target.innerText || event.explicitOriginalTarget.innerText;
                this.setNewFinancialDataEntryYear(this.activeTabYear);
                this.returnProjectData();
                // console.warn('Clicked with Active Tab : ', this.activeTabYear , ' With a Year ID of ', this.returnActiveTabYearId)

                // Get the project documentation for this tab IF available.
            },
            handleClickProject(tab, event){
                this.activeTabProject = event.target.innerText || event.explicitOriginalTarget.innerText;
                alert('Clear / Reset questions');
            },
            next() {

                if (this.active++ > 4) {
                    // this.active = 0;
                    alert('Completed');
                }

            },
            previous() {
                if (this.active-- <= 0) this.active = 0;
            },
            optionWasSelection(option) {
                return (this.step_3.activities.includes(option))
            },
            optionWasSelectionProjectTechnical(option) {
                return (this.step_5.checkedOptions.includes(option))
            },
            handleSuccess(response) {
                /*
                * Store response object
                * Render List
                * */

                // console.warn(' Project Documentation Component : handleSuccess ', response);

                // Succes varies on 'number' of 1 -7 and 'link' as the URL
                switch (response.number) {
                    case 1:
                        this.step_4.f1 = response.link;
                        break;
                    case 2:
                        this.step_4.f2 = response.link;
                        break;
                    case 3:
                        this.step_4.f3 = response.link;
                        break;
                    case 4:
                        this.step_4.f4 = response.link;
                        break;
                    case 5:
                        this.step_4.f5 = response.link;
                        break;
                    case 6:
                        this.step_4.f6 = response.link;
                        break;
                    case 7:
                        this.step_4.f7 = response.link;
                        break;
                    default:
                        break;
                }

                this.$notify({
                    title: 'Success',
                    message: 'Form was stored successfully.',
                    type: 'success'
                });

            },
            handleChange(obj1) {
            },
            handleRemove() {
            },
            handlePreview() {
            },
        },
    };
</script>

<style lang="scss" scoped>
</style>
