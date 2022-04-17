import React from 'react';
import Button from '@/Components/Button';
import Input from '@/Components/Input';
import Label from '@/Components/Label';
import ValidationErrors from '@/Components/ValidationErrors';
import {Head, useForm} from '@inertiajs/inertia-react';

export default function Import(props) {
    const {type} = props;

    const {data, setData, post, processing, errors} = useForm({
        files: [],
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.files[0]);
    };

    const submit = (e) => {
        e.preventDefault();
        post(route(type + '.import'), data);
    };

    return (
        <div>
            <Head title="Import"/>

            <ValidationErrors errors={errors}/>

            <form onSubmit={submit}>
                <div>
                    <Label forInput="name" value="Import from json file"/>

                    <Input
                        type="file"
                        name="files"
                        className="mt-1 block"
                        isFocused={true}
                        handleChange={onHandleChange}
                        required
                    />
                </div>


                <div className="flex items-center justify-end mt-4">
                    <Button className="ml-4" processing={processing}>
                        Upload
                    </Button>
                </div>
            </form>
        </div>
    );
}
