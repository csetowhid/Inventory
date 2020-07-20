<template>
<div>
    
</div>
</template>

<script>
export default {
    created() {
        //User.logout();
        localStorage.removeItem('token')
		localStorage.removeItem('user')
        Toast.fire({
                      icon: 'success',
                      title: 'Successfully Sign Out '
                    })
            this.$router.push({name: '/'})
    }
}
</script>
<style>
</style>
