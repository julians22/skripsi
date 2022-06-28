<template>
    <div>
        <div class="form-group row">
            <label for="category" class="col-md-2 col-form-label">{{ title }}</label>
            <div class="col-md-10">
                <input type="hidden" name="selected_category" v-bind:value="getCategoryId(selected_category)">
                <v-select label="name"
                    v-model="selected_category"
                    :options="categories"
                    placeholder="Select Category"
                    @search="onSearch"
                    @deselected="selected_category = null"
                    >
                    <template #list-footer v-if="categories.length < 1 && create_route != null">
                        <li class="px-1">
                            <a class="btn btn-success btn-block btn-sm" :href="create_route" target="blank" type="button">Add new</a>
                        </li>
                    </template>
                </v-select>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        categories_model: {
            type: Array,
        },
        create_route: {
            type: String,
            default: '',
        },
        selected: {
            default: null,
        },
        title: {
            default: 'Select Category',
        }
    },
    data() {
        return {
            categories: [],
            selected_category: null,
        }
    },
    created() {
        this.categories = this.categories_model;
        if(this.selected) {
            this.selected_category = this.selected;
        }
    },
    methods: {
        onSearch(search, loading) {
            if(search.length) {
                loading(true);
                this.search(loading, search, this)
            }
        },
        search: _.debounce((loading, search, vm) => {
            axios.get('/ajax/getCategories?search=' + search)
                .then(res => {
                    vm.categories = res.data;
                    loading(false);
                })
                .catch(error => {
                    console.log(error);
                    loading(false);
                });
        }, 500),
        getCategoryId(category) {
            if(category) {
                return category.id;
            }
            return 0;
        }
    }
}
</script>

<style>

</style>
