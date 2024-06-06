<template>
    <table class="table fl-table mb-0">
        <thead>
            <slot name="header">
                <tr>
                    <th 
                        v-for="(column, index) in headers" 
                        class="cursor-pointer"
                        :key="index"
                    >
                        <div 
                            v-if="hasCheckbox != 0 && hasCheckbox == index + 1" 
                            class="custom-control custom-checkbox"
                        >
                            <input 
                                name="color" 
                                value="primary" 
                                type="checkbox" 
                                class="custom-control-input" 
                                id="all-course" 
                                @click="selectAllCheckbox($event)"
                            >
                            <label class="custom-control-label" for="all-course"></label>
                        </div>
                        <span>
                            {{ column }}
                        </span>
                    </th>
                </tr>
            </slot>
        </thead>
        <tbody>    
            <slot></slot> 
        </tbody>
    </table>
</template>

<script>

    export default {
        props: {
            headers: {
                type: Array,
                default: []
            },
            hasCheckbox: {
                type: Number,
                default: 0
            }
        },   

        mounted() {
        },
        
        data() {
            return {}
        },

        methods: {
            selectAllCheckbox(event) {
                var slides = document.getElementsByClassName("course-checkbox").forEach(function(checkbox) {
                    if (event.target.checked == true) {
                        if (checkbox.checked == false) {
                            checkbox.click()
                        }
                    } else {
                        if (checkbox.checked == true) {
                            checkbox.click()
                        }
                    }
                });
            },
        }
    }
</script>
