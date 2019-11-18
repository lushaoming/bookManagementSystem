<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="/lib/vue.js"></script>
<script type="text/javascript" src="/js/{{\App\Libs\ASSETS_FILE['js']['global']}}"></script>

<script>
    function previousPage() {
        if (vm.page > 1) {
            vm.page--;
            get_list();
        }
    }

    function nextPage() {
        if (vm.page < vm.last_page) {
            vm.page++;
            get_list();
        }
    }
</script>
<!--/_footer 作为公共模版分离出去-->