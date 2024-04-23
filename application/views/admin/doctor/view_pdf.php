<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML to PDF</title>
    <!-- Include html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div id="content" class="container">
    <div class="logo" style="text-align: center; margin-top:20px">
        <!-- Set base URL dynamically using JavaScript -->
        <img id="logoImage" src="" alt="" width="160px" height="100px">
    </div>
    <!-- Button to trigger PDF generation -->
    <button onclick="generatePDF()" style="float: right;">Download PDF</button>

    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-md-6">
                <div class="logo" style="text-align: center; margin-top:20px">
                <div id="content">
    <div class="row">
        <?php if ($data->image1 != "") { ?>
            <div class="col-md-6">
                <a href="<?php echo base_url() . $data->image1 ?>" target="_blank" rel="noopener noreferrer">
                    <img style="border:solid #008000 1px;padding: 5px;" id="image1" height="100" width="100" src="<?php echo base_url() . $data->image1 ?>">
                </a>
            </div>
        <?php } ?>
        <?php if ($data->image2 != "") { ?>
            <div class="col-md-6">
                <a href="<?php echo base_url() . $data->image2 ?>" target="_blank" rel="noopener noreferrer">
                    <img style="border:solid #008000 1px;padding: 5px;" id="image2" height="100" width="100" src="<?php echo base_url() . $data->image2 ?>">
                </a>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <?php if ($data->image3 != "") { ?>
            <div class="col-md-6">
                <a href="<?php echo base_url() . $data->image3 ?>" target="_blank" rel="noopener noreferrer">
                    <img style="border:solid #008000 1px;padding: 5px;" id="image3" height="100" width="100" src="<?php echo base_url() . $data->image3 ?>">
                </a>
            </div>
        <?php } ?>
        <?php if ($data->image4 != "") { ?>
            <div class="col-md-6">
                <a href="<?php echo base_url() . $data->image4 ?>" target="_blank" rel="noopener noreferrer">
                    <img style="border:solid #008000 1px;padding: 5px;" id="image4" height="100" width="100" src="<?php echo base_url() . $data->image4 ?>">
                </a>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <?php if ($data->image5 != "") { ?>
            <div class="col-md-6">
                <a href="<?php echo base_url() . $data->image5 ?>" target="_blank" rel="noopener noreferrer">
                    <img style="border:solid #008000 1px;padding: 5px;" id="image5" height="100" width="100" src="<?php echo base_url() . $data->image5 ?>">
                </a>
            </div>
        <?php } ?>
    </div>
</div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="content" style="margin-top: 50px;">
                <?php $i = 1;
                    
                                            $this->db->select('*');
                                            $this->db->from('tbl_farmers');
                                            $this->db->where('id', $data->farmer_id);
                                            $farmer_data = $this->db->get()->row();
                                            $this->db->select('*');
                                            $this->db->from('tbl_doctor');
                                            $this->db->where('id', $data->doctor_id);
                                            $doctor_data = $this->db->get()->row();
                                        ?>
                    <h6 style="margin-top: 30px;">Farmer name : <?php echo $farmer_data->name  ?></h6>
                    <h6 style="margin-top: 30px;">Farmer number: <?php echo $farmer_data->name  ?></h6>
                    <h6 style="margin-top: 30px;">Doctor Name: <?php echo $farmer_data->name  ?></h6>
                    <h6 style="margin-top: 30px;">Doctor Number: <?php echo $farmer_data->name  ?></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-md-6">
                <div class="content" style="margin-top: 50px;">
                    
                    <h5 style="margin-top: 30px;">Description: <?php echo $data->description  ?></h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="content" style="margin-top: 50px;">
                <h5 style="margin-top: 30px;">Reason : <?php echo $data->reason  ?></h5>
                    <h5 style="margin-top: 30px;">Fees: <?php echo $data->fees  ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script to generate PDF -->
<script>
// Define the base URL dynamically using JavaScript
var baseUrl = '<?php echo base_url(); ?>';

// Set the image sources using the base URL
document.getElementById('logoImage').src = baseUrl + 'assets/dairy-1.png';
document.getElementById('image').src = baseUrl + 'assets/dairy-1.png';

// Function to generate PDF
function generatePDF() {
    // Define options for PDF generation
    const options = {
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };

    // Call html2pdf to convert HTML to PDF
    html2pdf().from(document.getElementById('content')).set(options).toPdf().get('pdf').then(function(pdf) {
        // Trigger download of PDF
        pdf.save();
    }).catch(function(error) {
        // Log any errors to the console
        console.error('Error generating PDF:', error);
    });
}
</script>

<!-- Include Popper.js and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
