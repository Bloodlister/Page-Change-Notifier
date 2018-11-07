export default {
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
            extraData: {
                min: 1990,
                max: 2018,
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
