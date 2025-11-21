<template>
  <div class="a4-page">
    <div class="header-attachment">
      Attachment to CS Form No. 212
    </div>

    <h1 class="form-title">WORK EXPERIENCE SHEET</h1>

    <div class="instructions">
      <p><strong>Instructions:</strong> 1. Include only the work experiences relevant to the position being applied to.</p>
      <p class="indent">2. The duration should include start and finish dates, if known, month in abbreviated form, if known, and year in full. For the current position, use the word <strong>Present</strong>, e.g., 1998-Present. Work experience should be listed from <strong>most recent first</strong>.</p>
    </div>

    <!-- <div class="sample-header">
      Sample: If applying to <strong>Supervising Administrative Officer (Human Resource Management Officer IV)</strong>
    </div> -->

    <div v-for="(entry, index) in experiences" :key="index" class="experience-entry">
      <div class="info-grid">
        <div class="bullet">•</div>
        <div class="label">Duration</div>
        <div class="separator">:</div>
        <div class="value">{{ entry.duration }}</div>

        <div class="bullet">•</div>
        <div class="label">Position</div>
        <div class="separator">:</div>
        <div class="value">{{ entry.position }}</div>

        <div class="bullet">•</div>
        <div class="label">Name of Office/Unit</div>
        <div class="separator">:</div>
        <div class="value">{{ entry.officeUnit }}</div>

        <div class="bullet">•</div>
        <div class="label">Immediate Supervisor</div>
        <div class="separator">:</div>
        <div class="value">{{ entry.supervisor }}</div>

        <div class="bullet">•</div>
        <div class="label">Name of Agency/Organization and Location</div>
        <div class="separator">:</div>
        <div class="value">{{ entry.agencyLocation }}</div>
      </div>

      <div class="section-block">
        <div class="section-header">
          <span class="bullet">•</span>
          <span class="label-text">List of Accomplishments and Contributions (if any)</span>
        </div>
        <ul v-if="entry.accomplishments.length" class="accomplishment-list">
          <li v-for="(acc, accIndex) in entry.accomplishments" :key="accIndex">
            {{ acc }}
          </li>
        </ul>
      </div>

      <div class="section-block">
        <div class="section-header">
          <span class="bullet">•</span>
          <span class="label-text">Summary of Actual Duties</span>
        </div>
        <p class="duties-text">
          {{ entry.duties }}
        </p>
      </div>
    </div>

    <div class="footer">
      <div class="signature-block">
        <div class="signature-line" />
        <div class="signature-text">(Signature over Printed Name of Employee/Applicant)</div>
      </div>
      <div class="date-block">
        <div class="date-line">Date: <u>{{ formattedDate }}</u></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'

defineProps({
  experiences: Array,
})

const formattedDate = new Date().toLocaleDateString('en-US', {
  year: 'numeric',
  month: 'long',
  day: 'numeric',
})

onMounted(() => {
  // Auto-print when component mounts
  window.print()
})
</script>

<style scoped>
/* Page Setup */
.a4-page {
  width: 210mm;
  min-height: 297mm;
  margin: 0 auto;
  background: white;
  padding: 40px 50px; /* Standard document margins */
  font-family: Arial, Helvetica, sans-serif;
  color: #000;
  box-sizing: border-box;
  font-size: 11pt; /* Standard form font size */
  line-height: 1.3;
}

/* Typography */
.header-attachment {
  text-align: right;
  font-style: italic;
  font-size: 10pt;
  margin-bottom: 15px;
}

.form-title {
  text-align: center;
  font-weight: bold;
  font-size: 14pt;
  text-transform: uppercase;
  background: rgb(150, 150, 150);
  color: white;
  font-style: italic;
  padding: 5px 0 5px 0;
  margin: 0;
  border: solid black 1px;
  -webkit-print-color-adjust: exact;
  print-color-adjust: exact;
}

/* Instructions */
.instructions {
  margin-bottom: 0px;
  font-style: italic; /* Instructions are typically italicized in these forms */
  font-size: 10pt;
  background-color: rgb(234, 234, 234);
  border: solid black 1px;
  -webkit-print-color-adjust: exact;
  print-color-adjust: exact;
}

.instructions p {
  margin: 0 0 3px 0;
  padding: 10px;
}

.instructions .indent {
  padding-left: 90px;
}

/* Sample Header */
.sample-header {
  margin-bottom: 15px;
  font-size: 11pt;
}

/* Experience Entry Layout */
.experience-entry {
  margin-bottom: 0px;
  border: solid black 1px;
  padding: 10px;
}

/* Grid Layout for perfect alignment of labels and values */
.info-grid {
  display: grid;
  /* Columns: Bullet | Label | Separator | Value */
  grid-template-columns: 20px 260px 15px 1fr;
  row-gap: 2px;
  margin-bottom: 10px;
}

.bullet {
  font-weight: bold;
}

.label {
  font-weight: bold;
}

.separator {
  text-align: center;
}

.value {
  /* Ensure text aligns properly if it wraps */
  text-transform: uppercase;
  
}

/* Accomplishments and Duties */
.section-block {
  margin-top: 5px;
}

.section-header {
  display: flex;
  font-weight: bold;
  margin-bottom: 3px;
}

.section-header .bullet {
  width: 20px;
  flex-shrink: 0;
}

.accomplishment-list {
  margin: 0;
  padding-left: 40px; /* Indent list content */
  list-style-type: none; /* Remove default bullets, use dashes if preferred or plain */
}

.duties-text {
  margin: 0;
  padding-left: 40px; /* Indent paragraph content */
  text-align: justify;
  white-space: pre-wrap;
}

/* Footer */
.footer {
  margin-top: 90px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-end;
  page-break-inside: avoid;
}

.signature-block {
  width: 45%;
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.signature-line {
  border-bottom: 1px solid #000;
  margin-bottom: 5px;
  width: 100%;
}

.signature-text {
  font-size: 10pt;
}

.date-block {
  width: 45%;
  margin-top: 40px;
}

/* Print Media Query */
@media print {
  body {
    margin: 0;
    padding: 0;
  }
  .a4-page {
    width: 100%;
    margin: 0;
    padding: 0; /* Printer handles margins */
    border: none;
  }
  
}
</style>