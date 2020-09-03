<template>
  <div class="user_wrapper">
      <table class="table table-bordered table-stripped shadow">
          <tbody>
              <tr>
                  <th>Name:</th>
                  <td>{{ userdetails.name ? userdetails.name : '' }}</td>
              </tr>
              <tr>
                  <th>Email</th>
                  <td>{{ userdetails.email ? userdetails.email : '' }}</td>
              </tr>
              <tr>
                  <th>Profile Status:</th>
                  <td>
                    <span class="text-white p-2 rounded" :class="profile_status == 'Active' ? 'bg-success' : ''">{{ profile_status  }}</span>
                  </td>
              </tr>
          </tbody>
      </table>
  </div>    
</template>

<script>
export default {
    name: 'GeneralUsers',
    props: ['userdetails'],
    computed: {
        profile_status() {
            if (this.userdetails.admin_approval) {
                if (this.userdetails.admin_approval == 1) {
                    return 'Active'
                } else {
                    return 'Inactive'
                }
            } else {
                return 'Unknown';
            }
        }
    }
}
</script>