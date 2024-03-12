<div class="footer text-center">
    <img src="{{ asset('asset/images/frontend/softguide_logo.png') }}">
</div><!-- footer -->
</body>
<script src="{{ asset('asset/js/common.js') }}"></script>
<script src="{{ asset('asset/frontend/js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('asset/frontend/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('asset/frontend/js/OverlayScrollbars.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('#dropdownMenuLink').dropdown();
    });

    $(function() {
        $("#items").height(520);
        $("#items").overlayScrollbars({
            overflowBehavior: {
                x: "hidden",
                y: "scroll"
            }
        });
        $("#cart").height(445);
        $("#cart").overlayScrollbars({});
    });
</script>

</html>
