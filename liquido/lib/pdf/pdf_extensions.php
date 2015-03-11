<?

// My Addons START //

define('PDFTAG_PTPERMM', 0.3528); // points per mm 1pt = 1/72 inch = 0.3528 mm
define('MEASURE_REGEX', "([0-9]{1,5}(\.[0-9]{1,}){0,1})([ ]{0,1})(cm|mm|in|pt){0,1}");

/**
* recalculates measures for width, height into pt
* source measurements: cm, mm, in(ch), pt
* @access private
* @param string $value
* @return float
*/
function measure2Pt($value) {
    if(ereg(MEASURE_REGEX, $value, $regs)) {
        if(in_array($regs[4], array("cm", "mm", "in", "pt"))) {
            switch($regs[4]) {
                case 'cm':
                    $regs[1] = $regs[1] / 2.54 * 72;
                    break;
                case 'mm':
                    $regs[1] = ($regs[1] / 10.0 ) / 2.54 * 72;
                    break;
                case 'in':
                    $regs[1] = 72 * $regs[1];
                    break;
                case 'pt':
                    /* nothing to do $regs[1] does already contains the right value */
                    break;
                default:
                    /* unknown type, we add an error message */
                    $this->warning("wrong measurement unit '$regs[4]'");
                    break;
            }
            //print "$value = $regs[1] <br>";
            return (float)$regs[1];
        } else {
            return (float)$regs[1];
        }
    } else {
        return 0;
    }
}

function fromTop($value) {
	global $pdf;
	return $pdf->ez['pageHeight']-measure2Pt($value);
}

function fromTopMargin($value) {
	global $pdf;
	return fromTop($value)-$pdf->ez['topMargin'];
}

function fromBottom($value) {
	return measure2Pt($value);
}

function fromBottomMargin($value) {
	global $pdf;
	return fromBottom($value)+$pdf->ez['bottomMargin'];
}

function fromRight($value) {
	global $pdf;
	return $pdf->ez['pageWidth']-measure2Pt($value);
}

function fromRightMargin($value) {
	global $pdf;
	return fromRight($value)-$pdf->ez['rightMargin'];
}

function fromLeft($value) {
	return measure2Pt($value);
}

function fromLeftMargin($value) {
	global $pdf;
	return fromLeft($value)+$pdf->ez['leftMargin'];
}

function getInnerWidth() {
	global $pdf;
	return $pdf->ez['pageWidth']-$pdf->ez['rightMargin']-$pdf->ez['leftMargin'];
}

// My Addons END //

require_once('class.ezpdf.php');

?>
