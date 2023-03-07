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
        // async ShipingAmntCalc(ProId, Qty) {
        //     const DataShipamnt = await this.callAxios(this.site_url, {'action':'ShipingAmnt',ProId:ProId,Qty:Qty}, 'post');
        //         return DataShipamnt;
        //     //     console.log( JSON.parse(JSON.stringify(ProId) || '[]'))
        // },
        addToCart(productId) {

            // this.cartCount = 5;
            // console.log(isAlertVisible)
            // alert(this.cartCount);
            // return 3;

            // console.log(isAlertVisible)
            // alert('common')
            //add to cart server

            if (localStorage.userData) {
                alert('here')
                // this.cartItem = JSON.stringify(JSON.parse(localStorage.getItem("cartItem") || '[]'))
                this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
                this.cartItem.push({
                    productId: productId,
                    qty: 1
                });
                alert(useTodosStore().$state.cartCount)
                useTodosStore().$state.cartCount +=1;
                // console.log(JSON.stringify(this.cartItem))
                // axios.post(this.site_url, {
                //     action: 'addToCart',
                //     userId: this.userData.id,
                //     proArray: (JSON.stringify(this.cartItem)),
                //     mobile: this.userData.mobileno,
                //     fromApp: 'diyaStoreSite',
                // })
                //     .then(result => {
                //         // console.log(typeof result.data)
                //         console.log(result.data)
                //     });

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
