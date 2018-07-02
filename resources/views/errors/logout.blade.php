<script>
    alert("{{__('auth.msg_logout')}}");
    window.location.href = "{{route($route , compact('rd'))}}";
</script>