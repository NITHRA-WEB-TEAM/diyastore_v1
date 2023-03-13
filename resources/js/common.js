import axios from "axios";
import {useTodosStore} from "@/store/store1"

export default {
    data() {
        return {
            cartItem: [],
            cartCount: 0,
            favouriteList: [],
            site_url: 'http://localhost:8000/api/site/action',
            userAbilities: [{"action": "manage", "subject": "all"}],
        }
    },
    created() {
        if (localStorage.userAbilities) {
        } else {
            localStorage.setItem('userAbilities', JSON.stringify(this.userAbilities))
            location.reload();
        }
        // $('#cartAlert').hide();
    },
    methods: {
        GoToCart(productId){
            this.$router.push({ path: `/diya/cart`});
        },
        sweetAlertConfirm(icon, title, text) {
            this.$swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'Remove',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$swal.fire(
                        'Deleted!',
                        'Successfully Removed From Your Cart',
                        'success'
                    )
                }
            })
        },
        onlyNumber($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57)) { // 46 is dot
                $event.preventDefault();
            }
        },
        sweetalert(title,desc,icon){
            this.$swal.fire(
                title,
                desc,
                icon
            )
        },
        addToCart(productId) {
            if (localStorage.userData) {
                // this.cartItem = JSON.stringify(JSON.parse(localStorage.getItem("cartItem") || '[]'))
                this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
                this.cartItem.push({
                    productId: productId,
                    qty: 1
                });
                useTodosStore().$state.cartCount +=1;
                console.log(JSON.stringify(this.cartItem))
                axios.post(this.site_url, {
                    action: 'addToCart',
                    userId: this.userData.id,
                    proArray: (JSON.stringify(this.cartItem)),
                    mobile: this.userData.mobileno,
                    fromApp: 'diyaStoreSite',
                })
                    .then(result => {
                    });
                this.cartItem = []

            } else {
                if (localStorage.cartItem) {
                    this.cartItem = JSON.parse(localStorage.getItem("cartItem") || '[]')
                    let proQty = this.cartItem.filter(x => x.productId == productId).map(x => x.qty);
                    let proId = this.cartItem.filter(x => x.productId == productId).map(x => x.productId);
                    if (!proQty.length) {
                        this.cartItem.push({
                            productId: productId,
                            qty: 1
                        });
                        useTodosStore().$state.cartCount +=1;
                        localStorage.setItem("cartItem", JSON.stringify(this.cartItem));
                    }
                    // console.log(JSON.stringify(this.cartItem))
                    // JSON.stringify(this.cartItem[i][productId]['qty'])
                } else {
                    // alert('no local')
                    // alert(productId)
                    this.cartItem.push({
                        productId: productId,
                        qty: 1
                    });
                    useTodosStore().$state.cartCount +=1;
                    // console.log(JSON.stringify(this.cartItem))
                    localStorage.setItem("cartItem", JSON.stringify(this.cartItem));
                }
            }
            // console.log(this.$router)
        },
        callAxios(url, data, requestMethod) {

            const response1 = axios({
                method: requestMethod,
                url: url,
                data: data,
            })
                .then(function (response) {
                    return (response);
                })
                .catch(function (error) {
                    return error;
                });
            return response1;
        },
        addToFavourite(productId) {

            if (localStorage.userData) {
                this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
                this.favouriteList.push({
                    productId: productId
                });
                // console.log(JSON.stringify(this.ProductsList));
                // return 1;
                // this.favouriteList = JSON.stringify(JSON.parse(localStorage.getItem("favouriteList") || '[]'))
                axios.post(this.site_url, {
                    action: 'addToFavourite',
                    userId: this.userData.id,
                    proArray: JSON.stringify(this.favouriteList),
                    mobile: this.userData.mobileno,
                    fromApp: 'diyaStoreSite',
                })
                    .then(result => {

                        // console.log(result.data)
                        // console.log('here 12')
                        // alert(this.categoryId)
                    });

                this.favouriteList = [];
            } else {
                if (localStorage.favouriteList) {
                    // alert('local')
                    // alert(productId)
                    this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
                    let proId = this.favouriteList.filter(x => x.productId == productId).map(x => productId.productId);
                    // console.log(proId)
                    if (proId.length) {
                        // alert('remove pro')
                        var deleted_index = this.favouriteList.findIndex(item => item.productId === productId);
                        this.favouriteList.splice(deleted_index, 1);

                        // this.favouriteList.forEach((value, index) => {
                        //     if (value.productId == productId) {
                        //        console.log(JSON.stringify(value))
                        //         // value.splice(index,1)
                        //     }
                        localStorage.setItem("favouriteList", JSON.stringify(this.favouriteList));
                        // })
                    } else {
                        // alert('add new')
                        this.favouriteList.push({
                            productId: productId,
                        });
                        localStorage.setItem("favouriteList", JSON.stringify(this.favouriteList));
                    }
                    // console.log(JSON.stringify(this.favouriteList))
                    // JSON.stringify(this.favouriteList[i][productId]['qty'])
                } else {
                    // alert('no local')
                    // alert(productId)
                    this.favouriteList.push({
                        productId: productId,
                    });
                    // console.log(JSON.stringify(this.favouriteList))
                    localStorage.setItem("favouriteList", JSON.stringify(this.favouriteList));
                }
            }
        },
    }
}
