/** @format */

'use strict';
$("[name='Date_Year']").change(function () {
    this.closest('form').submit();
});
