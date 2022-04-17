import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import {Head} from '@inertiajs/inertia-react';

export default function ProductView(props) {
    const {product, articles} = props;

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Product</h2>}
        >
            <Head title="Products"/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div><b>Name:</b> {product['name']}</div>
                            <div><b>Price:</b> {product['price']}</div>
                            <div className="pt-12 pb-6 text-xl text-center">Product Articles</div>
                            <div className="table w-full pt-6">
                                <div className="table-header-group">
                                    <div className="table-row font-bold">
                                        <div className="table-cell text-left text-center">Article Id</div>
                                        <div className="table-cell text-left text-center">Name</div>
                                        <div className="table-cell text-left text-center">Amount</div>
                                        <div className="table-cell text-left text-center">Stock</div>
                                    </div>
                                </div>
                                {articles.map((article, index) => {
                                    const bg = (index % 2 !== 0) ? "bg-slate-50" : ""
                                    return <div key={index} className={["table-row-group", bg].join(' ')}>
                                        <div className="table-row">
                                            <div className="table-cell p-3 text-center">{article['art_id']}</div>
                                            <div className="table-cell p-3 text-center">{article['name']}</div>
                                            <div className="table-cell p-3 text-center">{article['amount']}</div>
                                            <div className="table-cell p-3 text-center">{article['stock']}</div>
                                        </div>
                                    </div>
                                })}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
