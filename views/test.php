<script>
$('td').click(function() {
    console.log(getJson2(this));
    setAttr(this, 'holis', 'fernadno');
    console.log(getJson2(this));
})
</script>