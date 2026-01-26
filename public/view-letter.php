<?php
require_once '../src/Database.php';
require_once '../src/LetterManager.php';
require_once '../src/LetterTemplate.php';

$id = $_GET['id'] ?? 0;
$letter = LetterManager::getLetter($id);

if (!$letter) {
    die("Letter not found.");
}

$data = json_decode($letter['data_json'], true);
$letterType = ['name' => $letter['type_name'], 'slug' => $letter['type_slug']];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letter View - <?= htmlspecialchars($letter['type_name']) ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #0f2854 !important;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .toolbar {
            width: 100%;
            background: #1c4d8d;
            color: white;
            padding: 10px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn {
            background: #bde8f5;
            color: #0f2854;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn:hover {
            background: #4988c4;
            color: white;
        }

        .page-wrapper {
            margin: 30px auto;
            width: 210mm;
            height: 296mm;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            background: white;
            overflow: hidden;
        }

        @media print {
            body {
                background: white !important;
                display: block;
            }
            .toolbar {
                display: none !important;
            }
            .page-wrapper {
                margin: 0 !important;
                box-shadow: none !important;
                width: 210mm !important;
                height: 296mm !important;
                overflow: hidden !important;
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button onclick="history.back()" class="btn">&larr; Back</button>
        <button onclick="downloadPDF()" class="btn">Download PDF</button>
        <button onclick="window.print()" class="btn">Print</button>
    </div>

    <div class="page-wrapper" id="letter-content">
        <?= LetterTemplate::renderLetter($data, $letterType) ?>
    </div>

    <script>
        function downloadPDF() {
            // Scroll to top to prevent blank PDF generation
            window.scrollTo(0, 0);
            
            const element = document.getElementById('letter-content');
            // Target the inner container for precise A4 dimensions
            const content = element.querySelector('.letter-container') || element;
            
            // Temporarily force left alignment to prevent "half doc vanished" / overflow issues
            const originalMargin = content.style.margin;
            content.style.margin = '0';
            
            const opt = {
                margin: [0, 0, 0, 0], // Explicit zero margins
                filename: '<?= $letter['type_slug'] ?>_<?= $data['roll_no'] ?? 'document' ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { 
                    scale: 2, 
                    useCORS: true,
                    scrollY: 0,
                    scrollX: 0,
                    letterRendering: true // Enable for better text alignment
                },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(content).save().then(() => {
                // Restore original margin after generation
                content.style.margin = originalMargin;
            });
        }
    </script>
</body>
</html>