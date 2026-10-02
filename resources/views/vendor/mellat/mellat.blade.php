<form id="form" action="https://bpm.shaparak.ir/pgwchannel/startpay.mellat" method="post" target="_self">
    <input type="hidden" name="RefId" value="{{$refId}}">
</form>
<script>
    var form=document.getElementById('form');
    setTimeout(function () {
        form.submit();
    },1000);
</script>
