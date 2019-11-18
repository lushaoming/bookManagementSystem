<!-- 表格页尾，显示分页等 -->
<div class="dataTables_info" role="status" aria-live="polite">显示@{{ list_start }}到@{{ list_end }}条，共@{{ total }}条</div>
<div class="dataTables_paginate paging_simple_numbers">
    <a class="paginate_button previous" aria-controls="DataTables_Table_0" onclick="previousPage()">上一页</a>
    <span><a class="paginate_button current" aria-controls="DataTables_Table_0">@{{ page }}</a></span>
    <a class="paginate_button next" aria-controls="DataTables_Table_0" onclick="nextPage()">下一页</a>
</div>
