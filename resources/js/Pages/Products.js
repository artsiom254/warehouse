import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import {Head, InertiaLink} from '@inertiajs/inertia-react';
import {Inertia} from "@inertiajs/inertia";
import Import from "@/Components/Import";

export default function Products(props) {
    const {products} = props;

    const deleteProduct = (id) => {
        if (!confirm('Are you sure')) return;
        Inertia.post(route('products.delete'), {id: id});
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Products</h2>}
        >
            <Head title="Products"/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="table w-full">
                                <div className="table-header-group">
                                    <div className="table-row font-bold">
                                        <div className="table-cell text-left text-center">Name</div>
                                        <div className="table-cell text-left text-center">Price</div>
                                        <div className="table-cell text-left text-center">Quantity</div>
                                        <div className="table-cell text-left text-center">Max Quantity</div>
                                        <div className="table-cell text-left text-center">Actions</div>
                                    </div>
                                </div>
                                {products.map((product, index) => {
                                    const bg = (index % 2 !== 0) ? "bg-slate-50" : ""
                                    return <div key={index} className={["table-row-group", bg].join(' ')}>
                                        <div className="table-row">
                                            <div className="table-cell p-3 text-center">{product['name']}</div>
                                            <div className="table-cell p-3 text-center">{product['price']}</div>
                                            <div className="table-cell p-3 text-center">{product['quantity']}</div>
                                            <div className="table-cell p-3 text-center">{product['max_quantity']}</div>
                                            <div className="table-cell p-3 text-center">
                                                <button className="ml-2 rounded-none p-2 text-indigo-800 text-white">
                                                    <InertiaLink href={route('products.show', {product})}>
                                                        View
                                                    </InertiaLink>
                                                </button>
                                                <button className="rounded-none p-2 text-rose-800 text-white"
                                                        onClick={() => deleteProduct(product.id)}
                                                >
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                })}
                            </div>
                        </div>

                        <div className="p-6 bg-white border-b border-gray-200 w-3/12">
                            <Import type={'products'}/>
                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
