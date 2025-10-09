
<?php snippet('header') ?>
<main>
</main>
<?php snippet('footer') ?>

<script>
    const https = require('https');

// API 키 또는 토큰을 준비합니다.
const apiKey = '5f7fa8c821ae2c7533e497ffe1a3ea41'; // 네온 CRM API 키

// API 엔드포인트 URL 설정
const apiUrl = 'https://api.neo-crm.com/forms';
const orgID =  '87-3023665';

// 요청 옵션 설정
const options = {
  method: 'GET',
  headers: {
    'Authorization': `Bearer ${apiKey}`,
    'Content-Type': 'application/json',
    'Organization-ID': ${orgID} 
  }
};

// 요청 보내기
https.get(apiUrl, options, (res) => {
  let data = '';

  // 응답 데이터 수신
  res.on('data', (chunk) => {
    data += chunk;
  });

  // 응답 데이터 수신 완료
  res.on('end', () => {
    if (res.statusCode === 200) {
      try {
        const forms = JSON.parse(data);
        const formIds = forms.map(form => form.id);
        console.log("Form IDs:", formIds);
      } catch (error) {
        console.error("Error parsing response data:", error);
      }
    } else {
      console.error(`Failed to retrieve forms: ${res.statusCode} ${res.statusMessage}`);
    }
  });

}).on('error', (e) => {
  console.error(`Error making request: ${e.message}`);
});
</script>