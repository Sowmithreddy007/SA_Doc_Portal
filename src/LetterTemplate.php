<?php

class LetterTemplate {
    
    /**
     * Format date with ordinal suffix (1st, 2nd, 3rd, 11th, etc.)
     */
    public static function formatOrdinalDate($date) {
        if (empty($date) || $date === 'now') {
            $timestamp = time();
        } else {
            $timestamp = strtotime($date);
        }
        
        $day = date('j', $timestamp);
        $suffix = self::getOrdinalSuffix($day);
        $month = date('F', $timestamp);
        $year = date('Y', $timestamp);
        
        return $day . $suffix . ' ' . $month . ' ' . $year;
    }
    
    /**
     * Get ordinal suffix for a number
     */
    private static function getOrdinalSuffix($number) {
        $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return 'th';
        }
        return $ends[$number % 10];
    }
    
    /**
     * Format regular date (for dates in content)
     */
    public static function formatDate($date) {
        if (empty($date)) return '';
        return self::formatOrdinalDate($date);
    }
    
    /**
     * Render letter header
     */
    public static function renderHeader() {
        return '
        <div class="letter-header">
            <div class="header-grid">
                <div class="header-left">
                    <img src="assets/right-logo.png" alt="Left Logo" class="header-logo">
                </div>
                <div class="header-center-title">
                    <h1 class="org-name">SPECANCIENS</h1>
                    <div class="header-details">
                        <p class="org-subtitle">(ALUMNI ASSOCIATION OF ST. PETER\'S ENGINEERING COLLEGE, HYDERABAD) <span class="org-sep">|</span> TELANGANA</p>
                        <p class="org-reg">REGISTERED UNDER THE ANDHRA PRADESH SOCIETIES ACT., 2001 <span class="org-sep">|</span> REG. NO. 32 OF 2016</p>
                    </div>
                </div>
                <div class="header-right">
                    <img src="assets/left-logo.png" alt="Right Logo" class="header-logo">
                </div>
            </div>
            <div class="header-divider"></div>
        </div>';
    }
    
    /**
     * Render letter footer
     */
    public static function renderFooter() {
        return '
        <div class="letter-footer">
            <p>Opp. Telangana Forest Academy, Dhulapally, Near Kompally, Medchal Dist.,</p>
            <p>Telangana, India - 500 100</p>
            <p>Mobile - +91 89770 59315 e-mail - specanciens@stpetershyd.com</p>
        </div>';
    }
    
    /**
     * Render complete letter template
     */
    public static function renderLetter($data, $letterType) {
        $date = self::formatOrdinalDate($data['present_date'] ?? 'now');
        $subject = $letterType['name'];
        $name = $data['name'] ?? '';
        $content = self::generateContent($data, $letterType);
        $signatory = $data['signatory_name'] ?? 'SHIREESH RAMMURTHY';
        $signatoryTitle = $data['signatory_title'] ?? 'President';
        $signatureImage = $data['signature_image'] ?? '';
        
        return '
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            @page {
                size: A4;
                margin: 0;
            }
            
            @media print {
                body {
                    margin: 0;
                    padding: 0;
                    background: white;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
                .letter-container {
                    margin: 0 !important;
                    border: none !important;
                    box-shadow: none !important;
                    page-break-after: avoid;
                    height: 296mm;
                    overflow: hidden;
                }
            }
            
            html, body {
                font-family: Arial, sans-serif;
                background: white;
            }
            
            .letter-container {
                width: 210mm;
                height: 296mm;
                margin: 0 auto;
                background: white;
                position: relative;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }
            
            /* Header Styles */
            .letter-header {
                padding: 2mm 10mm 0.5mm 10mm;
                flex: 0 0 auto;
                width: 100%;
                position: relative;
                z-index: 1;
            }
            .header-grid { 
                display: flex;
                justify-content: space-between;
                align-items: center; 
                width: 100%;
                gap: 15px;
                margin-bottom: 0;
            }
            .header-left { 
                flex: 0 0 auto;
                display: flex;
                align-items: center;
                align-self: center;
            }
            .header-center-title { 
                text-align: center; 
                font-family: "Times New Roman", Times, serif;
                flex: 1 1 auto;
                min-width: 0; /* critical: allow center to shrink so logos do not get pushed out */
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                padding-top: 0;
            }
            .header-right { 
                flex: 0 0 auto;
                display: flex;
                align-items: center;
                align-self: center;
            }
            .header-details {
                text-align: center;
                font-family: "Times New Roman", Times, serif;
                margin-top: 0;
                line-height: 1.1;
                max-width: 100%;
            }
            .org-name { 
                font-size: 34px; 
                font-weight: bold; 
                margin: 0; 
                color: #000; 
                letter-spacing: 1px;
                line-height: 1;
            }
            /* Allow wrapping so logos never disappear */
            .org-subtitle { font-size: 10px; margin: 0; font-weight: bold; white-space: normal; }
            .org-location { font-size: 11px; font-weight: bold; margin: 0; white-space: normal; }
            .org-reg { font-size: 9px; margin: 0; font-weight: bold; white-space: normal; }
            .org-sep { padding: 0 6px; font-weight: bold; white-space: nowrap; }
            
            .header-logo {
                height: 120px;
                width: auto;
                max-width: 200px;
                object-fit: contain;
            }
            
            .header-left .header-logo {
                border-radius: 100%;
            }
            
            .header-right .header-logo {
                height: 70px;
            }
            
            .header-divider { border-bottom: 3px solid #0f2854; margin-top: 2px; }
            
            /* Watermark */
            .watermark {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 100px;
                font-weight: bold;
                color: rgba(0, 0, 0, 0.05);
                z-index: 0;
                pointer-events: none;
                white-space: nowrap;
            }
            
            /* Body Styles */
            .letter-body {
                flex: 1;
                padding: 5mm 10mm;
                display: flex;
                flex-direction: column;
                font-size: 11pt;
                line-height: 1.5;
                position: relative;
                z-index: 1;
                font-family: "Times New Roman", Times, serif;
            }
            .letter-date { text-align: left; margin-bottom: 20px; }
            .letter-subject { font-weight: bold; text-decoration: underline; margin-bottom: 20px; text-align: center; }
            .letter-greeting { margin-bottom: 15px; }
            .letter-content { flex: 1; text-align: justify; }
            .letter-content p { margin-bottom: 10px; }
            .letter-content ul { margin-bottom: 10px; padding-left: 20px; }
            
            /* Signature */
            .letter-signature { 
                margin-top: 40px; 
                margin-bottom: 20px; 
                text-align: right;
            }
            .signature-container {
                display: inline-block;
                text-align: left;
            }
            .signature-image {
                height: 80px;
                width: auto;
                max-width: 250px;
                display: block;
                margin-bottom: 10px;
                object-fit: contain;
            }
            .signature-line { 
                width: 200px; 
                border-top: 1px solid #000; 
                margin-bottom: 8px; 
            }
            .signatory-name { 
                font-weight: bold; 
                font-size: 12pt;
                margin-bottom: 2px;
            }
            .signatory-title {
                font-size: 11pt;
                color: #333;
                margin-top: 0;
            }
            
            /* Footer Styles */
            .letter-footer {
                flex: 0 0 auto;
                width: 100%;
                background-color: #0f2854;
                color: white;
                padding: 10px;
                text-align: center;
                font-size: 9pt;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                position: relative;
                z-index: 1;
            }
            .letter-footer p { margin: 2px 0; }
        </style>
        <div class="letter-container">
            <div class="watermark">SPECANCIENS</div>
        ' . self::renderHeader() . '
            <div class="letter-body">
                <div class="letter-date">Date: ' . htmlspecialchars($date) . '</div>
                <div class="letter-subject">Subject: ' . htmlspecialchars($subject) . '</div>
                <div class="letter-greeting">Dear ' . htmlspecialchars($name) . ',</div>
                <div class="letter-content">
                    ' . $content . '
                </div>
                <div class="letter-signature">
                    <div class="signature-container">
                        ' . (!empty($signatureImage) ? '<img src="' . (strpos($signatureImage, 'data:image') === 0 ? $signatureImage : htmlspecialchars($signatureImage)) . '" alt="Signature" class="signature-image">' : '') . '
                        <div class="signature-line"></div>
                        <div class="signatory-name">' . htmlspecialchars($signatory) . '</div>
                        <div class="signatory-title">(' . htmlspecialchars($signatoryTitle) . ')</div>
                    </div>
                </div>
            </div>
            ' . self::renderFooter() . '
        </div>';
    }
    
    /**
     * Generate letter content based on type
     */
    private static function generateContent($data, $letterType) {
        $slug = $letterType['slug'];
        $content = '';
        
        switch($slug) {
            case 'release':
                $content = '<p>This is to inform you that you have successfully completed your term as <strong>' . htmlspecialchars($data['position'] ?? '') . '</strong> in the SPECANCIENS Alumni Association from ' . self::formatDate($data['start_date'] ?? '') . ' to ' . self::formatDate($data['end_date'] ?? '') . '.</p>';
                if (isset($data['end_date'])) {
                    $content .= '<p>Your last working day is ' . self::formatDate($data['end_date']) . ', 11:59PM.</p>';
                }
                $content .= '<p>We are pleased with your services during your tenure as <strong>SATISFACTORY</strong>.</p>';
                if (isset($data['contributions']) && !empty($data['contributions'])) {
                    $content .= '<p>Your contributions to the Alumni Association include:</p><ul>';
                    foreach(explode("\n", $data['contributions']) as $contribution) {
                        if (trim($contribution)) {
                            $content .= '<li>' . htmlspecialchars(trim($contribution)) . '</li>';
                        }
                    }
                    $content .= '</ul>';
                }
                $content .= '<p>We appreciate your contribution to the organization\'s growth and success. We wish you the best for your future endeavors and thank you for your services.</p>';
                break;
                
            case 'appointment':
                $content = '<p>We are pleased to appoint you as <strong>' . htmlspecialchars($data['position'] ?? '') . '</strong> in the SPECANCIENS Alumni Association effective ' . self::formatDate($data['start_date'] ?? '') . '.</p>';
                if (isset($data['duration'])) {
                    $content .= '<p>Your term will be for a period of ' . htmlspecialchars($data['duration']) . '.</p>';
                }
                $content .= '<p>We look forward to your valuable contributions to the Alumni Association.</p>';
                break;
                
            case 'lor':
                $content = '<p>This is to certify that <strong>' . htmlspecialchars($data['name'] ?? '') . '</strong> has served as <strong>' . htmlspecialchars($data['position'] ?? '') . '</strong> in the SPECANCIENS Alumni Association from ' . self::formatDate($data['start_date'] ?? '') . '.</p>';
                if (isset($data['custom_body']) && !empty($data['custom_body'])) {
                    $content .= '<p>' . nl2br(htmlspecialchars($data['custom_body'])) . '</p>';
                }
                break;
                
            case 'promotion':
                $content = '<p>We are pleased to inform you that you have been promoted from <strong>' . htmlspecialchars($data['previous_position'] ?? '') . '</strong> to <strong>' . htmlspecialchars($data['present_position'] ?? '') . '</strong> in the SPECANCIENS Alumni Association effective ' . self::formatDate($data['start_date'] ?? '') . '.</p>';
                if (isset($data['years_served'])) {
                    $content .= '<p>You have served the organization for ' . htmlspecialchars($data['years_served']) . ' years.</p>';
                }
                if (isset($data['last_working_day'])) {
                    $content .= '<p>Your last working day in the previous position was ' . self::formatDate($data['last_working_day']) . '.</p>';
                }
                $content .= '<p>We congratulate you on this achievement and look forward to your continued contributions.</p>';
                break;
                
            case 'termination':
                $content = '<p>This is to inform you that your association with SPECANCIENS Alumni Association is being terminated effective ' . self::formatDate($data['present_date'] ?? 'now') . '.</p>';
                if (isset($data['remarks']) && !empty($data['remarks'])) {
                    $content .= '<p><strong>Reason:</strong> ' . nl2br(htmlspecialchars($data['remarks'])) . '</p>';
                }
                break;
                
            case 'undertaking':
                $content = '<p>This is to confirm that <strong>' . htmlspecialchars($data['name'] ?? '') . '</strong> has been appointed as <strong>' . htmlspecialchars($data['position'] ?? '') . '</strong> in the SPECANCIENS Alumni Association for a duration of ' . htmlspecialchars($data['duration'] ?? '') . '.</p>';
                if (isset($data['remarks']) && !empty($data['remarks'])) {
                    $content .= '<p>' . nl2br(htmlspecialchars($data['remarks'])) . '</p>';
                }
                break;
                
            default:
                $content = '<p>This letter is issued by SPECANCIENS Alumni Association.</p>';
        }
        
        return $content;
    }
}
