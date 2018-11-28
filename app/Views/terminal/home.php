<?php
echo "\n";
echo isset($this->data['message']) ? $this->data['message'] : '';
echo $this->data['grid'];
if (isset($this->data['enterCoordinates']) && $this->data['enterCoordinates'] == true) {
    echo 'Enter coordinates (row, col), e.g. A5: ';
}
