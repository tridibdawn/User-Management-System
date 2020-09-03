<template>
  <div class="container">
        <ul class="nav nav-tabs" id="users" role="tablist">
            <li class="nav-item" role="presentation">
                <a 
                    class="nav-link active" 
                    id="active-users-tab" 
                    data-toggle="tab" 
                    href="#active-users" 
                    role="tab" 
                    aria-controls="active-users" 
                    aria-selected="true"
                >Active Users</a>
            </li>
            <li class="nav-item" role="presentation">
                <a 
                    class="nav-link" 
                    id="inactive-users-tab" 
                    data-toggle="tab" 
                    href="#inactive-users" 
                    role="tab" 
                    aria-controls="inactive-users" 
                    aria-selected="false"
                >Inactive Users</a>
            </li>
        </ul>
        <div class="tab-content" id="usersTabContent">
            <div class="tab-pane fade show active" id="active-users" role="tabpanel" aria-labelledby="active-users-tab">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in active_users" :key="item.id">
                            <td>{{ item.name }}</td>
                            <td>{{ item.email }}</td>
                            <td><span class="bg-success rounded text-white p-2">{{ item.admin_approval == 1 ? 'Active' : 'Pending' }}</span></td>
                            <td>
                                <button class="btn btn-outline-danger" @click.prevent="approveOrDisapproveUser(item.id,'0')">Disapprove User</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="inactive-users" role="tabpanel" aria-labelledby="inactive-users-tab">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in inactive_users" :key="item.id">
                            <td>{{ item.name }}</td>
                            <td>{{ item.email }}</td>
                            <td><span class="bg-gray rounded text-white p-2">{{ item.admin_approval == 1 ? 'Active' : 'Pending' }}</span></td>
                            <td>
                                <button class="btn btn-outline-success" @click.prevent="approveOrDisapproveUser(item.id,'1')">Approve User</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
  </div>
</template>

<script>
export default {
    name: 'AdminUsers',
    data() {
        return {
            active_users: [],
            inactive_users: []
        };
    },
    mounted() {
        this.getActiveUsers();
        this.getInactiveUsers();
    },
    methods: {
        getActiveUsers() {
            axios.get('/api/active-users')
            .then(res => {
                this.active_users = res.data.data;
            }).catch(err => {
                console.log(err)
            });
        },
        getInactiveUsers() {
            axios.get('/api/inactive-users')
            .then(res => {
                this.inactive_users = res.data.data;
            }).catch(err => {
                console.log(err)
            });
        },
        approveOrDisapproveUser(user_id, admin_approval) {
            let formData = new FormData();
            formData.append('user_id', user_id);
            formData.append('admin_approval', admin_approval);
            axios.post('/api/approve-or-disapprove-users', formData)
            .then(res => {
                this.getActiveUsers();
                this.getInactiveUsers();
            }).catch(err => console.log(err));
        }
    }
}
</script>