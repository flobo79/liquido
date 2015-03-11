/**
 * Table rowMark
 *
 * myRow = new rowMark(1,2,3,4)
 *
 *   1:	Farbe des Over Effekts z.B. "#ff0000" - string
 *   2:	Farbe des Mark Effeks - string
 *   3:	Farbe des Over Effeks bei der Marked Row - string
 *   4: Funktion die bei onClick aufgerufen wird - string
 *
 *   <tr class="grau" onMouseOver="myRow.over(this)" onMouseOut="myRow.out(this)" onClick="myRow.click(this)">
 *       <td>eine Zeile</td>
 *       <td><img src="einbild.gif"></td>
 *   </tr>
 */
function rowMark(overColor, markedColor, overMarked, onClick) {
	
    /**
     * Set class properties
     * @access private
     */		
    this.overColor = overColor;
    this.markedColor = markedColor;
    this.overMarked = overMarked;
    this.onClick = onClick;

    /**
     * dynamic properties
     * @access private
     */
    this.oldColor = '';
    this.oldColorMarked = '';
    this.markedRow = '';

    /**
     * Define class methods
     * @access private
     */
    this.over = rowMark_over;
    this.out = rowMark_out;
    this.click = rowMark_click;

    /**
     * Browsercheck
     * @access private
     */
    this.browser = '';

}

/**
 * rowMark::over()
 * @param object oRow table row object
 */
function rowMark_over(oRow) {

    if ( oRow.style.backgroundColor != this.markedColor ) {
        this.oldColor = oRow.style.backgroundColor;
    }
    
    if ( oRow.style.backgroundColor == this.markedColor ) {
        oRow.style.backgroundColor = this.overMarked;
    } else {
        oRow.style.backgroundColor = this.overColor;
    }
    
}

/**
 * rowMark::out()
 * @param object oRow table row object
 */
function rowMark_out(oRow) {

    if (oRow == this.markedRow) {
        oRow.style.backgroundColor = this.markedColor;
    } else {
        oRow.style.backgroundColor = this.oldColor;
    }
    
}

/**
 * rowMark::over()
 * @param object oRow table row object
 */
function rowMark_click(oRow) {

    if ( "" == this.markedRow ) {
        oRow.style.backgroundColor = this.markedColor;
        this.markedRow = oRow;
        this.oldColorMarked = this.oldColor;
        
        if ( "" != this.onClick ) {
            eval( this.onClick );
        }
        
    } else {
        this.markedRow.style.backgroundColor = this.oldColorMarked;
        oRow.style.backgroundColor = this.markedColor;
        this.markedRow = oRow;
        this.oldColorMarked = this.oldColor;
        
        if ( "" != this.onClick ) {
            eval( this.onClick );
        }
    }
}

/* rowMark instance for the
   Content area */
con = new rowMark('#FAFAFA', '#EFEFEF', '#E8E8E8', 'conInjectData(oRow)');

function conInjectData( obj ) {
    tmp_data = obj.id;
    data = tmp_data.split("-");
    //parent.frames['left_top'].cfg.load(data[0], data[1], data[2], data[3], tmp_data);   
}