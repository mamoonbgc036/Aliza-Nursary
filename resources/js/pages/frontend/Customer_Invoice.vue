<template>
    <div id="hello">
      <h1>Hello</h1>
      <button @click="generatePdf">Generate PDF</button>
    </div>
  </template>
  
  <script>
  import html2pdf from 'html2pdf.js';
  
  export default {
    methods: {
      async generatePdf() {
        const content = document.getElementById('hello'); // Get the content to convert to PDF
  
        // Configure the PDF options
        const pdfOptions = {
          margin: 10,
          filename: 'generated-pdf.pdf',
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        };
  
        try {
          // Generate the PDF as a data URI
          const pdfBlob = await html2pdf().from(content).set(pdfOptions).output('blob');

// Create a data URL from the PDF blob
const pdfDataUri = URL.createObjectURL(pdfBlob);

// Open the PDF in a new tab
window.open(pdfDataUri, '_blank');
        } catch (error) {
          console.error('PDF generation error:', error);
        }
      },
    },
  };
  </script>
  