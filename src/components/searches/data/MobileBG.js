export default {
    brandModel: {
        hrefValues: {
            brand: 'as',
            model: 'sa',
        },
        brandOptions: [
            {
                label: 'Audi',
                hrefValue: 'ff',
            },
            {
                label: 'BMW',
                hrefValue: 'fw',
            },
        ],
        modelOptions: {
            ff: [
                {
                    label: 'Audi A1',
                    hrefValue: 'aa',
                },
                {
                    label: 'Audi B2',
                    hrefValue: 'ab',
                },
            ],
            fw: [
                {
                    label: 'BMW butt',
                    hrefValue: 'BB',
                },
                {
                    label: 'BMW iaksb',
                    hrefValue: 'dsakjh',
                },
            ],
        },
    },
    price: {
        scopeData: {
            active: false,
            label: 'Price',
            hrefValues: {
                min: 'f7',
                max: 'f8',
            },
            extraData: {
                max: 30000,
            },
        },
        dropdownData: {
            hrefValue: 'f9',
            options: [
                { value: 'лв.', label: 'лв.' },
                { value: 'USD', label: 'USD' },
                { value: 'EUR', label: 'EUR' },
            ],
            default: 'лв.',
        },
    },
    betweens: [
        {
            active: false,
            label: 'Year',
            hrefValues: {
                min: 'f10',
                max: 'f11',
            },
        },
    ],
    checkboxes: [
        {
            hrefValue: 'f22',
            label: 'Has Pictures',
        },
    ],
};
