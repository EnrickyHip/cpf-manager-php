<?php

dataset('invalid_formats', function () {
  return [
    "123123.000-00",
    "000.000.000.05",
    "aaa.aaa.aaa-aa",
    "aaaaaaaaaaa",
    "aaa.aaa.000.00",
    "000-000-000-05",
    "000-000-000.05",
    "000-000.000-05",
    "00000000005",
    "000.000.000.00",
    "9999999",
    "000.000-00",
    "123123123123",
    "123.123.123-123",
  ];
});

dataset('non_11_digits', function () {
  return [
    "999999",
    "aaaa",
    "2384729834",
    "238.472.983-4",
    "999.999.9",
    "aaa.a",
    "676785634657",
    "123.123.123-123",
    "652-809-610-433",
    "aaa.aaa.aaa-aa"
  ];
});

dataset('valid_but_not_formated_cpfs', function () {
  return [
    "142.224.10098",
    "859.956.94065",
    "995.98818063",
    "456451.630- 28",
    "24.770763026",
    "11149.279028",
    "45-6569.25030",
    "8105-885-2043",
  ];
});

dataset('valid_cpfs', function () {
  return [
    "124.469.769-99",
    "859.956.940-65",
    "995.988.180-63",
    "456.451.630-28",
    "24770763026",
    "11149279028",
    "45656925030",
    "81058852043",
  ];
});

dataset('invalid_cpfs', function () {
  return [
    "142.224.100-88",
    "859.956.940-75",
    "995.988.180-53",
    "456.451.630-18",
    "24770763006",
    "11149279008",
    "45658925030",
    "81056852043",
  ];
});

dataset('sequences', function () {
  return [
    "000.000.000-00",
    "111.111.111-11",
    "222.222.222-22",
    "333.333.333-33",
    "444.444.444-44",
    "555.555.555-55",
    "66666666666",
    "77777777777",
    "88888888888",
    "99999999999",
  ];
});
